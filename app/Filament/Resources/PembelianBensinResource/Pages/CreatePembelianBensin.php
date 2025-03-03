<?php

namespace App\Filament\Resources\PembelianBensinResource\Pages;

use App\Filament\Resources\PembelianBensinResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePembelianBensin extends CreateRecord
{
    protected static string $resource = PembelianBensinResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
