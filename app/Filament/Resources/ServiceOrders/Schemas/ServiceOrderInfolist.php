<?php

namespace App\Filament\Resources\ServiceOrders\Schemas;

use App\Models\ServiceOrder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ServiceOrderInfolist
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
                TextEntry::make('technician_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('problem'),
                TextEntry::make('priority')
                    ->badge()
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('so_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('done_at')
                    ->dateTime()
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
                    ->visible(fn (ServiceOrder $record): bool => $record->trashed()),
            ]);
    }
}
