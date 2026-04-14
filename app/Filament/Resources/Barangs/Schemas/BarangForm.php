<?php

namespace App\Filament\Resources\Barangs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BarangForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kategori_id')
                    ->label('Kategori')
                    ->relationship('kategori', 'kategori_nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('barang_kode')
                    ->label('Kode Barang')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(10),
                TextInput::make('barang_nama')
                    ->label('Nama Barang')
                    ->required()
                    ->maxLength(100),
                TextInput::make('harga_beli')
                    ->label('Harga Beli')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('harga_jual')
                    ->label('Harga Jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
            ]);
    }
}
