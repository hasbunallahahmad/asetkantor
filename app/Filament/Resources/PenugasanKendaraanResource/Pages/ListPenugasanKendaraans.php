<?php

namespace App\Filament\Resources\PenugasanKendaraanResource\Pages;

use App\Filament\Resources\PenugasanKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenugasanKendaraans extends ListRecords
{
    protected static string $resource = PenugasanKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
