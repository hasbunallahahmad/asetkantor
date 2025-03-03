<?php

namespace App\Filament\Resources\ServisKendaraanResource\Pages;

use App\Filament\Resources\ServisKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditServisKendaraan extends EditRecord
{
    protected static string $resource = ServisKendaraanResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Servis kendaraan berhasil diperbarui')
            ->body('Data servis kendaraan telah berhasil diperbarui.');
    }
}
