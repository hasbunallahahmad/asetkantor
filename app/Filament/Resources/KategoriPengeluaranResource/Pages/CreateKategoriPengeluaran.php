<?php

namespace App\Filament\Resources\KategoriPengeluaranResource\Pages;

use App\Filament\Resources\KategoriPengeluaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriPengeluaran extends CreateRecord
{
    protected static string $resource = KategoriPengeluaranResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
