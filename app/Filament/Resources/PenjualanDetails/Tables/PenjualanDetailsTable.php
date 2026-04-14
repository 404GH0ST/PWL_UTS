<?php

namespace App\Filament\Resources\PenjualanDetails\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PenjualanDetailsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('detail_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('penjualan.penjualan_kode')
                    ->label('Kode Penjualan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('barang.barang_nama')
                    ->label('Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('subtotal')
                    ->label('Subtotal')
                    ->state(fn ($record): int => $record->harga * $record->jumlah)
                    ->money('IDR'),
            ])
            ->filters([
                SelectFilter::make('penjualan_id')
                    ->label('Penjualan')
                    ->relationship('penjualan', 'penjualan_kode'),
                SelectFilter::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama'),
            ])
            ->recordActions([])
            ->toolbarActions([]);
    }
}
