<?php

namespace App\Filament\Resources\Ocupations\Schemas;

use App\Models\Ocupation;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class OcupationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('uuid')
                    ->label('UUID'),
                TextEntry::make('user_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('tenant_id')
                    ->numeric(),
                TextEntry::make('ocupant_id')
                    ->numeric(),
                TextEntry::make('unit_id')
                    ->numeric(),
                TextEntry::make('order_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->columnSpanFull(),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('expire_at')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Ocupation $record): bool => $record->trashed()),
                TextEntry::make('period')
                    ->placeholder('-'),
            ]);
    }
}
