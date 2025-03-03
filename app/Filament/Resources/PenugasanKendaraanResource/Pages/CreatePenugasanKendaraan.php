<?php

namespace App\Filament\Resources\PenugasanKendaraanResource\Pages;

use App\Filament\Resources\PenugasanKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePenugasanKendaraan extends CreateRecord
{
    protected static string $resource = PenugasanKendaraanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
