<?php

namespace App\Filament\Resources\PembayaranStnkResource\Pages;

use App\Filament\Resources\PembayaranStnkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembayaranStnks extends ListRecords
{
    protected static string $resource = PembayaranStnkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
