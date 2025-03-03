<?php

namespace App\Filament\Resources\PembelianBensinResource\Pages;

use App\Filament\Resources\PembelianBensinResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPembelianBensin extends EditRecord
{
    protected static string $resource = PembelianBensinResource::class;
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
