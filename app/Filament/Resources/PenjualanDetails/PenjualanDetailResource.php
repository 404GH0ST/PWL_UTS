<?php

namespace App\Filament\Resources\PenjualanDetails;

use App\Filament\Resources\PenjualanDetails\Pages\ListPenjualanDetails;
use App\Filament\Resources\PenjualanDetails\Tables\PenjualanDetailsTable;
use App\Models\PenjualanDetail;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use UnitEnum;

class PenjualanDetailResource extends Resource
{
    protected static ?string $model = PenjualanDetail::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationLabel = 'Detail Penjualan';

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 8;

    public static function table(Table $table): Table
    {
        return PenjualanDetailsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPenjualanDetails::route('/'),
        ];
    }
}
