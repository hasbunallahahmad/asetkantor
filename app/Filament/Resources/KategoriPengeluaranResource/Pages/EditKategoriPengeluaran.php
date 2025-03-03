<?php

namespace App\Filament\Resources\KategoriPengeluaranResource\Pages;

use App\Filament\Resources\KategoriPengeluaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriPengeluaran extends EditRecord
{
    protected static string $resource = KategoriPengeluaranResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
