<?php

namespace App\Filament\Resources\PembayaranStnkResource\Pages;

use App\Filament\Resources\PembayaranStnkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembayaranStnk extends EditRecord
{
    protected static string $resource = PembayaranStnkResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
