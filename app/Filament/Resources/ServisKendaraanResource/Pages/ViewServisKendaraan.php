<?php

namespace App\Filament\Resources\ServisKendaraanResource\Pages;

use App\Filament\Resources\ServisKendaraanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewServisKendaraan extends ViewRecord
{
  protected static string $resource = ServisKendaraanResource::class;

  protected function getHeaderActions(): array
  {
    return [
      Actions\EditAction::make(),
      Actions\DeleteAction::make(),
    ];
  }
}
