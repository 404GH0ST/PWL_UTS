<x-filament-panels::page>
    {{ $this->form }}

    <x-filament::section heading="Ringkasan Periode">
        <div style="display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">
            <div>
                <div>Total Transaksi</div>
                <div><strong>{{ $this->totalTransaksi }}</strong></div>
            </div>

            <div>
                <div>Total Item Terjual</div>
                <div><strong>{{ $this->totalItem }}</strong></div>
            </div>

            <div>
                <div>Omzet Periode</div>
                <div><strong>{{ $this->formatRupiah($this->omzet) }}</strong></div>
            </div>

            <div>
                <div>Barang Terlaris</div>
                @if ($this->barangTerlaris)
                    <div><strong>{{ $this->barangTerlaris['nama'] }}</strong></div>
                    <div>{{ $this->barangTerlaris['jumlah'] }} item</div>
                @else
                    <div>Belum ada transaksi.</div>
                @endif
            </div>
        </div>
    </x-filament::section>

    <x-filament::section heading="Daftar Transaksi">
        {{ $this->table }}
    </x-filament::section>
</x-filament-panels::page>
