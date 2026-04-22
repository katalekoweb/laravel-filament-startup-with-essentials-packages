<?php

namespace App\Filament\Resources\Ocupations\Pages;

use App\Filament\Resources\Ocupations\OcupationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOcupation extends CreateRecord
{
    protected static string $resource = OcupationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
