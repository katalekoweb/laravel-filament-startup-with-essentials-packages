<?php

namespace App\Filament\Resources\Ocupations;

use App\Filament\Resources\Ocupations\Pages\CreateOcupation;
use App\Filament\Resources\Ocupations\Pages\EditOcupation;
use App\Filament\Resources\Ocupations\Pages\ListOcupations;
use App\Filament\Resources\Ocupations\Pages\ViewOcupation;
use App\Filament\Resources\Ocupations\Schemas\OcupationForm;
use App\Filament\Resources\Ocupations\Schemas\OcupationInfolist;
use App\Filament\Resources\Ocupations\Tables\OcupationsTable;
use App\Models\Ocupation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OcupationResource extends Resource
{
    protected static ?string $model = Ocupation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'notes';

    public static function form(Schema $schema): Schema
    {
        return OcupationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OcupationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OcupationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOcupations::route('/'),
            'create' => CreateOcupation::route('/create'),
            'view' => ViewOcupation::route('/{record}'),
            'edit' => EditOcupation::route('/{record}/edit'),
        ];
    }
}
