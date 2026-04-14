<?php

namespace App\Filament\Resources\PenjualanDetails\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenjualanDetailForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('penjualan_id')
                    ->label('Penjualan')
                    ->relationship('penjualan', 'penjualan_kode')
                    ->required()
                    ->searchable()
                    ->preload(),
                Select::make('barang_id')
                    ->label('Barang')
                    ->relationship('barang', 'barang_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('harga')
                    ->label('Harga')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('jumlah')
                    ->label('Jumlah')
                    ->required()
                    ->numeric(),
            ]);
    }
}
