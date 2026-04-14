<?php

namespace App\Filament\Resources\Barangs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class BarangsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('barang_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('kategori.kategori_nama')
                    ->label('Kategori')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('barang_kode')
                    ->label('Kode Barang')
                    ->searchable(),
                TextColumn::make('barang_nama')
                    ->label('Nama Barang')
                    ->searchable(),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('harga_jual')
                    ->label('Harga Jual')
                    ->money('IDR')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'kategori_nama'),
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
