<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ElectionResource\Pages;
use App\Filament\Resources\ElectionResource\RelationManagers;
use App\Models\Election;
use App\Services\Components\AppIcons;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ElectionResource extends Resource
{
    protected static ?string $model = Election::class;

    protected static ?string $navigationIcon = AppIcons::ELECTION_ICON;

    protected static ?string $navigationGroup = 'Voting Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Start date and time')
                    ->required()
                    ->native(false)
                    ->timezone('Asia/Bangkok')
                    ->placeholder('Election start date and time')
                    ->live()
                    ->afterStateUpdated(fn(Set $set) => $set('end_date', null)),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('End date and time')
                    ->required()
                    ->native(false)
                    ->timezone('Asia/Bangkok')
                    ->placeholder('Election end date and time')
                    ->minDate(fn(Get $get) => $get('start_date')),
                Forms\Components\Toggle::make('is_active')
                    ->label('Is the election currently active?')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (bool $state, Set $set) {
                        if ($state == true) {
                            $set('completed', false);
                        }
                    }),
                Forms\Components\Toggle::make('completed')
                    ->label('Is the election completed?')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (bool $state, Set $set) {
                        if ($state == true) {
                            $set('is_active', false);
                        }
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d-M-Y h:i A', 'Asia/Bangkok')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('d-M-Y h:i A', 'Asia/Bangkok')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('completed')
                    ->boolean(),
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
                Tables\Actions\EditAction::make()->successNotificationTitle('Election updated successfully.'),
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
            'index' => Pages\ManageElections::route('/'),
        ];
    }
}
