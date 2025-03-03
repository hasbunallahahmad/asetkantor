<?php

namespace App\Filament\Resources\PembayaranStnkResource\Pages;

use App\Filament\Resources\PembayaranStnkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePembayaranStnk extends CreateRecord
{
    protected static string $resource = PembayaranStnkResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
