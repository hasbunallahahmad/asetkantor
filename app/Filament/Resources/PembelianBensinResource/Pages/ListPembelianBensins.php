<?php

namespace App\Filament\Resources\PembelianBensinResource\Pages;

use App\Filament\Resources\PembelianBensinResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPembelianBensins extends ListRecords
{
    protected static string $resource = PembelianBensinResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
