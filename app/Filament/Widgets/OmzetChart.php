<?php

namespace App\Filament\Widgets;

use App\Models\Penjualan;
use Filament\Widgets\ChartWidget;

class OmzetChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Omzet 7 Hari Terakhir';

    protected ?string $description = 'Tren omzet harian berdasarkan transaksi penjualan.';

    protected string $color = 'warning';

    protected function getData(): array
    {
        $tanggalAkhir = now()->endOfDay();
        $tanggalMulai = now()->subDays(6)->startOfDay();

        $penjualans = Penjualan::query()
            ->with('penjualanDetails')
            ->whereBetween('penjualan_tanggal', [$tanggalMulai, $tanggalAkhir])
            ->orderBy('penjualan_tanggal')
            ->get();

        $labels = [];
        $data = [];

        for ($tanggal = $tanggalMulai->copy(); $tanggal->lte($tanggalAkhir); $tanggal->addDay()) {
            $labels[] = $tanggal->translatedFormat('d M');

            $omzetHarian = $penjualans
                ->filter(fn (Penjualan $penjualan): bool => $penjualan->penjualan_tanggal->isSameDay($tanggal))
                ->sum('total_harga');

            $data[] = (int) $omzetHarian;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Omzet',
                    'data' => $data,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
