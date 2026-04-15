<?php

namespace App\Filament\Widgets;

use App\Models\PenjualanDetail;
use Filament\Widgets\ChartWidget;

class BarangTerlarisChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Top 5 Barang Terlaris';

    protected ?string $description = 'Barang dengan jumlah penjualan tertinggi pada seluruh transaksi.';

    protected string $color = 'warning';

    protected function getData(): array
    {
        $records = PenjualanDetail::query()
            ->selectRaw('barang_id, SUM(jumlah) as total_qty')
            ->with('barang')
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Terjual',
                    'data' => $records->pluck('total_qty')->map(fn (mixed $qty): int => (int) $qty)->all(),
                    'backgroundColor' => [
                        '#d97706',
                        '#f59e0b',
                        '#fbbf24',
                        '#fcd34d',
                        '#fde68a',
                    ],
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $records
                ->map(fn (PenjualanDetail $detail): string => $detail->barang?->barang_nama ?? 'Barang')
                ->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
