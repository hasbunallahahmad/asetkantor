<?php

namespace App\Filament\Resources\ServisKendaraanResource\Pages;

use App\Filament\Resources\ServisKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateServisKendaraan extends CreateRecord
{
    protected static string $resource = ServisKendaraanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Servis Kendaraan'),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
