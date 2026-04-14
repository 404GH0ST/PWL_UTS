<?php

namespace App\Filament\Resources\Stoks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StoksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('stok_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('supplier.supplier_nama')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.nama')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stok_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('stok_jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_nama'),
                SelectFilter::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama'),
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
