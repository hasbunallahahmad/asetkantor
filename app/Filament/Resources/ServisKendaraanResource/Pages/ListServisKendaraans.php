<?php

namespace App\Filament\Resources\ServisKendaraanResource\Pages;

use App\Filament\Resources\ServisKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServisKendaraans extends ListRecords
{
    protected static string $resource = ServisKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Servis Kendaraan'),
        ];
    }
}
