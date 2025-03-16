<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoterResource\Pages;
use App\Filament\Resources\VoterResource\RelationManagers;
use App\Models\Voter;
use App\Services\Components\AppIcons;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VoterResource extends Resource
{
    protected static ?string $model = Voter::class;

    protected static ?string $navigationIcon = AppIcons::VOTER_ICON;

    protected static ?string $navigationGroup = 'Voting Settings';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('voter_id')
                    ->required()
                    ->label('Voter ID')
                    ->helperText('Enter a unique voter ID')
                    ->unique()
                    ->maxLength(255),
                Forms\Components\Select::make('organization_id')
                    ->relationship('organization', 'name')
                    ->required()
                    ->placeholder('Please select organization')
                    ->searchable()
                    ->preload()
                    ->native(false),
                Forms\Components\Select::make('election_id')
                    ->relationship('election', 'title')
                    ->required()
                    ->columnSpanFull()
                    ->native(false),
                Forms\Components\Toggle::make('has_voted')
                    ->inline(false)
                    ->inlineLabel(false)
                    ->label('Has the user voted?')
                    ->helperText('When a voter wanted to undo the vote, toggle off this.')
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('voted_at', null)),
                Forms\Components\DateTimePicker::make('voted_at')
                    ->inlineLabel()
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('voter_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('organization.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('election.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('has_voted')
                    ->boolean(),
                Tables\Columns\TextColumn::make('voted_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->successNotificationTitle('Voter updated successfully.'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageVoters::route('/'),
        ];
    }
}
