<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PositionResource\Pages;
use App\Filament\Resources\PositionResource\RelationManagers;
use App\Models\Position;
use App\Services\Components\AppIcons;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = AppIcons::POSITION_ICON;

    protected static ?string $navigationGroup = 'Voting Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->maxLength(255),
                Forms\Components\Select::make('election_id')
                    ->relationship('election', 'title')
                    ->required()
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Is the position active?')
                    ->live()
                    ->afterStateUpdated(function (bool $state, Set $set) {
                        if ($state == true) {
                            $set('is_completed', false);
                            $set('elected_representative_id', null);
                        }
                    }),
                Toggle::make('is_completed')
                    ->label('Is the position elected?')
                    ->live()
                    ->afterStateUpdated(function (bool $state, Set $set) {
                        if ($state == true) {
                            $set('is_active', false);
                        }
                    }),
                Forms\Components\Select::make('elected_representative_id')
                    ->label('Elected Representative')
                    ->relationship('electedRepresentative', 'name')
                    ->required(fn(Get $get): bool => $get('is_completed') == true)
                    ->live()
                    ->disabled(fn(Get $get): bool => $get('is_completed') == false)
                    ->dehydrated(fn(Get $get): bool => $get('is_completed') == true)
                    ->afterStateUpdated(function ($state, Set $set) {
                        if ($state !== null) {
                            $set('is_active', false);
                            $set('is_completed', true);
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
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('election.title')
                    ->numeric()
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
                Tables\Actions\EditAction::make()->successNotificationTitle('Position updated successfully.'),
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
            'index' => Pages\ManagePositions::route('/'),
        ];
    }
}
