<?php

namespace App\Filament\Resources\Penjualans\Tables;

use App\Models\Penjualan;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PenjualansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('penjualan_id')
                    ->label('ID')
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('Kasir')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),
                TextColumn::make('penjualan_kode')
                    ->label('Kode')
                    ->searchable()
                    ->description(fn (Penjualan $record): string => 'Total: ' . self::formatRupiah(
                        (int) $record->penjualanDetails->sum(fn ($detail) => $detail->harga * $detail->jumlah)
                    )),
                TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('total_item')
                    ->label('Qty')
                    ->state(fn (Penjualan $record): int => (int) $record->penjualanDetails->sum('jumlah')),
            ])
            ->filters([
                SelectFilter::make('user_id')
                    ->label('Kasir')
                    ->relationship('user', 'nama'),
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

    protected static function formatRupiah(int $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}
