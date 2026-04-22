<?php

namespace App\Filament\Resources\Finances\Schemas;

use App\Models\Finance;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FinanceInfolist
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
                TextEntry::make('category_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ocupation_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('ocupant_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('title'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('amount')
                    ->numeric(),
                TextEntry::make('paid')
                    ->numeric(),
                TextEntry::make('missing')
                    ->numeric(),
                TextEntry::make('fine')
                    ->numeric(),
                TextEntry::make('number')
                    ->numeric(),
                TextEntry::make('expires_at')
                    ->date()
                    ->placeholder('-'),
                IconEntry::make('is_carnet')
                    ->boolean(),
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
                    ->visible(fn (Finance $record): bool => $record->trashed()),
            ]);
    }
}
