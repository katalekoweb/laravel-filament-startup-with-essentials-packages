<?php

namespace App\Filament\Resources\Ocupations\Pages;

use App\Filament\Resources\Ocupations\OcupationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOcupations extends ListRecords
{
    protected static string $resource = OcupationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
