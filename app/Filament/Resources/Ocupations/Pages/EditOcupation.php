<?php

namespace App\Filament\Resources\Ocupations\Pages;

use App\Filament\Resources\Ocupations\OcupationResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOcupation extends EditRecord
{
    protected static string $resource = OcupationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
