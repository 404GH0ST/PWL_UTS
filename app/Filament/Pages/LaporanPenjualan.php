<?php

namespace App\Filament\Pages;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use BackedEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use UnitEnum;

class LaporanPenjualan extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Laporan Penjualan';

    protected static string|UnitEnum|null $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 9;

    protected string $view = 'filament.pages.laporan-penjualan';

    /**
     * @var array<string, mixed>
     */
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'tanggal_mulai' => now()->startOfMonth()->toDateString(),
            'tanggal_selesai' => now()->toDateString(),
        ]);
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user?->isAdministrator() || $user?->isManager();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Filter Laporan')
                    ->schema([
                        DatePicker::make('tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->default(now()->startOfMonth())
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function (mixed $state, Set $set): void {
                                if ($this->getFilterValue('tanggal_selesai') && $state > $this->getFilterValue('tanggal_selesai')) {
                                    $set('tanggal_selesai', $state);
                                }

                                $this->resetTable();
                            }),
                        DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->default(now())
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn (): mixed => $this->resetTable()),
                    ])
                    ->columns(2),
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getPenjualanQuery())
            ->defaultSort('penjualan_tanggal', 'desc')
            ->columns([
                TextColumn::make('penjualan_kode')
                    ->label('Kode')
                    ->searchable(),
                TextColumn::make('penjualan_tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('user.nama')
                    ->label('Kasir')
                    ->searchable(),
                TextColumn::make('pembeli')
                    ->label('Pembeli')
                    ->searchable(),
                TextColumn::make('total_item')
                    ->label('Qty'),
                TextColumn::make('total_harga')
                    ->label('Total')
                    ->state(fn (Penjualan $record): string => $this->formatRupiah($record->total_harga)),
            ])
            ->paginated([10, 25, 50])
            ->emptyStateHeading('Belum ada transaksi pada periode ini.');
    }

    public function getPenjualansProperty(): Collection
    {
        return $this->getPenjualanQuery()
            ->with('penjualanDetails')
            ->get();
    }

    public function getTotalTransaksiProperty(): int
    {
        return $this->penjualans->count();
    }

    public function getTotalItemProperty(): int
    {
        return (int) $this->penjualans->sum('total_item');
    }

    public function getOmzetProperty(): int
    {
        return (int) $this->penjualans->sum('total_harga');
    }

    public function getBarangTerlarisProperty(): ?array
    {
        $detail = PenjualanDetail::query()
            ->selectRaw('barang_id, SUM(jumlah) as total_qty')
            ->with('barang')
            ->join('t_penjualan', 't_penjualan.penjualan_id', '=', 't_penjualan_detail.penjualan_id')
            ->when($this->getFilterValue('tanggal_mulai'), fn (Builder $query, string $tanggal) => $query->whereDate('t_penjualan.penjualan_tanggal', '>=', $tanggal))
            ->when($this->getFilterValue('tanggal_selesai'), fn (Builder $query, string $tanggal) => $query->whereDate('t_penjualan.penjualan_tanggal', '<=', $tanggal))
            ->groupBy('barang_id')
            ->orderByDesc('total_qty')
            ->first();

        if (! $detail) {
            return null;
        }

        return [
            'nama' => $detail->barang?->barang_nama ?? '-',
            'jumlah' => (int) $detail->total_qty,
        ];
    }

    public function formatRupiah(int $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }

    protected function getPenjualanQuery(): Builder
    {
        return Penjualan::query()
            ->with('user')
            ->when($this->getFilterValue('tanggal_mulai'), fn (Builder $query, string $tanggal) => $query->whereDate('penjualan_tanggal', '>=', $tanggal))
            ->when($this->getFilterValue('tanggal_selesai'), fn (Builder $query, string $tanggal) => $query->whereDate('penjualan_tanggal', '<=', $tanggal));
    }

    protected function getFilterValue(string $key): mixed
    {
        return data_get($this->data, $key);
    }
}
