<?php

namespace App\Filament\Resources\Penjualans\Schemas;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Closure;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Validation\ValidationException;

class PenjualanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Penjualan')
                    ->schema([
                        Select::make('user_id')
                            ->label('Kasir')
                            ->relationship('user', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(fn (): ?int => auth()->id())
                            ->disabled(fn (): bool => ! auth()->user()?->isAdministrator())
                            ->dehydrated()
                            ->helperText(fn (): ?string => auth()->user()?->isAdministrator()
                                ? null
                                : 'Kasir otomatis mengikuti akun yang sedang login.'),
                        TextInput::make('pembeli')
                            ->label('Nama Pembeli')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('penjualan_kode')
                            ->label('Kode Penjualan')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->readOnly()
                            ->dehydrated()
                            ->default(fn (): string => Penjualan::generateKode()),
                        DateTimePicker::make('penjualan_tanggal')
                            ->label('Tanggal Penjualan')
                            ->required()
                            ->default(now())
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn (mixed $state, Set $set, string $operation): null => $operation === 'create'
                                    ? $set('penjualan_kode', Penjualan::generateKode($state))
                                    : null
                            ),
                    ])
                    ->columns(2),
                Section::make('Detail Barang')
                    ->schema([
                        Repeater::make('penjualanDetails')
                            ->label('Item Penjualan')
                            ->relationship()
                            ->defaultItems(1)
                            ->minItems(1)
                            ->addActionLabel('Tambah Barang')
                            ->schema([
                                Select::make('barang_id')
                                    ->label('Barang')
                                    ->relationship('barang', 'barang_nama')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                    ->afterStateUpdated(fn (?string $state, Set $set) => self::syncHarga($state, $set)),
                                TextEntry::make('stok_tersedia')
                                    ->label('Stok Tersedia')
                                    ->state(fn (Get $get, ?PenjualanDetail $record): string => self::formatStokTersedia($get('barang_id'), $record)),
                                TextInput::make('harga')
                                    ->label('Harga')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->readOnly(),
                                TextInput::make('jumlah')
                                    ->label('Jumlah')
                                    ->required()
                                    ->integer()
                                    ->minValue(1)
                                    ->maxValue(fn (Get $get, ?PenjualanDetail $record): int => self::getStokTersedia($get('barang_id'), $record))
                                    ->rule(fn (Get $get, ?PenjualanDetail $record): Closure => self::stockRule($get('barang_id'), $record))
                                    ->live(),
                                TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->state(fn (Get $get): string => self::formatRupiah(((int) ($get('harga') ?? 0)) * ((int) ($get('jumlah') ?? 0)))),
                            ])
                            ->columns(2)
                            ->columnSpanFull()
                            ->mutateRelationshipDataBeforeCreateUsing(fn (array $data): array => self::prepareDetailData($data))
                            ->mutateRelationshipDataBeforeSaveUsing(fn (array $data, PenjualanDetail $record): array => self::prepareDetailData($data, $record)),
                        TextEntry::make('total_transaksi')
                            ->label('Total Transaksi')
                            ->state(fn (Get $get): string => self::formatRupiah(self::calculateTotal($get('penjualanDetails') ?? []))),
                    ]),
            ]);
    }

    protected static function syncHarga(?string $barangId, Set $set): void
    {
        $barang = Barang::query()->find($barangId);

        $set('harga', $barang?->harga_jual);
    }

    protected static function prepareDetailData(array $data, ?PenjualanDetail $record = null): array
    {
        $barang = Barang::query()->find($data['barang_id'] ?? null);

        if (! $barang) {
            return $data;
        }

        $data['harga'] = $data['harga'] ?: $barang->harga_jual;

        $stokTersedia = $barang->stokTersedia($record?->detail_id);

        if ((int) ($data['jumlah'] ?? 0) > $stokTersedia) {
            throw ValidationException::withMessages([
                'jumlah' => "Stok {$barang->barang_nama} tersisa {$stokTersedia}.",
            ]);
        }

        return $data;
    }

    protected static function formatStokTersedia(?string $barangId, ?PenjualanDetail $record = null): string
    {
        $barang = Barang::query()->find($barangId);

        if (! $barang) {
            return 'Pilih barang terlebih dahulu.';
        }

        return (string) $barang->stokTersedia($record?->detail_id);
    }

    protected static function getStokTersedia(?string $barangId, ?PenjualanDetail $record = null): int
    {
        $barang = Barang::query()->find($barangId);

        if (! $barang) {
            return 0;
        }

        return $barang->stokTersedia($record?->detail_id);
    }

    protected static function stockRule(?string $barangId, ?PenjualanDetail $record = null): Closure
    {
        return function (string $attribute, mixed $value, Closure $fail) use ($barangId, $record): void {
            $barang = Barang::query()->find($barangId);

            if (! $barang) {
                return;
            }

            $stokTersedia = $barang->stokTersedia($record?->detail_id);

            if ((int) $value > $stokTersedia) {
                $fail("Stok {$barang->barang_nama} tersisa {$stokTersedia}.");
            }
        };
    }

    protected static function calculateTotal(array $details): int
    {
        return (int) collect($details)->sum(
            fn (array $detail): int => ((int) ($detail['harga'] ?? 0)) * ((int) ($detail['jumlah'] ?? 0))
        );
    }

    protected static function formatRupiah(int $nominal): string
    {
        return 'Rp ' . number_format($nominal, 0, ',', '.');
    }
}
