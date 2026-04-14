<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Kasir')
                    ->relationship('user', 'nama')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('pembeli')
                    ->label('Nama Pembeli')
                    ->required()
                    ->maxLength(50),
                TextInput::make('penjualan_kode')
                    ->label('Kode Penjualan')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(20),
                DateTimePicker::make('penjualan_tanggal')
                    ->label('Tanggal Penjualan')
                    ->required()
                    ->default(now()),
            ]);
    }
}
