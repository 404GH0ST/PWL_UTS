<?php

namespace App\Filament\Resources\Penjualans\Pages;

use App\Filament\Resources\Penjualans\PenjualanResource;
use App\Models\Penjualan;
use Filament\Resources\Pages\CreateRecord;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! auth()->user()?->isAdministrator()) {
            $data['user_id'] = auth()->id();
        }

        $data['penjualan_kode'] = Penjualan::generateKode($data['penjualan_tanggal'] ?? null);

        return $data;
    }
}
