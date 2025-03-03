<?php

namespace App\Filament\Resources\LogAktivitasResource\Pages;

use App\Filament\Resources\LogAktivitasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLogAktivitas extends CreateRecord
{
    protected static string $resource = LogAktivitasResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
