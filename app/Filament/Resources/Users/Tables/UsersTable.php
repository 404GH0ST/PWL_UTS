<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('level.level_nama')
                    ->label('Level')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('username')
                    ->label('Username')
                    ->searchable(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('level_id')
                    ->label('Level')
                    ->relationship('level', 'level_nama'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
