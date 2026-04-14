<?php

namespace App\Filament\Resources\PenjualanDetails\Pages;

use App\Filament\Resources\PenjualanDetails\PenjualanDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPenjualanDetail extends EditRecord
{
    protected static string $resource = PenjualanDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
