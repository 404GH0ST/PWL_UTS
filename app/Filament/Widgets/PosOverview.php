<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\Penjualan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PosOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $barangs = Barang::query()
            ->with(['stoks', 'penjualanDetails'])
            ->get();

        $penjualansHariIni = Penjualan::query()
            ->with('penjualanDetails')
            ->whereDate('penjualan_tanggal', today())
            ->get();

        return [
            Stat::make('Total Barang', (string) $barangs->count())
                ->description('Jumlah master barang yang aktif')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),
            Stat::make('Stok Tersedia', (string) $barangs->sum(fn (Barang $barang): int => $barang->stokTersedia()))
                ->description('Akumulasi stok semua barang')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('warning'),
            Stat::make('Transaksi Hari Ini', (string) $penjualansHariIni->count())
                ->description('Jumlah transaksi pada tanggal hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('primary'),
            Stat::make('Omzet Hari Ini', self::formatRupiah((int) $penjualansHariIni->sum('total_harga')))
                ->description('Akumulasi penjualan hari ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }

    protected static function formatRupiah(int $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}
