<?php

namespace App\Filament\Resources\PenugasanKendaraanResource\Pages;

use App\Filament\Resources\PenugasanKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenugasanKendaraan extends EditRecord
{
    protected static string $resource = PenugasanKendaraanResource::class;
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
