<?php

namespace App\Filament\Resources\KategoriPengeluaranResource\Pages;

use App\Filament\Resources\KategoriPengeluaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriPengeluarans extends ListRecords
{
    protected static string $resource = KategoriPengeluaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
