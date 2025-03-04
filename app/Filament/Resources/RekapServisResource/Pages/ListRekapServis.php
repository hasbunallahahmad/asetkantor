<?php

namespace App\Filament\Resources\RekapServisResource\Pages;

use App\Filament\Resources\RekapServisResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapServis extends ListRecords
{
    protected static string $resource = RekapServisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
