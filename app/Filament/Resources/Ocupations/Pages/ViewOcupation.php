<?php

namespace App\Filament\Resources\Ocupations\Pages;

use App\Filament\Resources\Ocupations\OcupationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOcupation extends ViewRecord
{
    protected static string $resource = OcupationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
