<?php

namespace App\Filament\Resources\ServiceOrders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('uuid')
                    ->label('UUID')
                    ->required(),
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('tenant_id')
                    ->required()
                    ->numeric(),
                TextInput::make('category_id')
                    ->numeric(),
                TextInput::make('ocupation_id')
                    ->numeric(),
                TextInput::make('ocupant_id')
                    ->numeric(),
                TextInput::make('technician_id')
                    ->numeric(),
                TextInput::make('problem')
                    ->required(),
                Select::make('priority')
                    ->options(['baixa' => 'Baixa', 'media' => 'Media', 'alta' => 'Alta']),
                Textarea::make('description')
                    ->columnSpanFull(),
                DatePicker::make('so_date'),
                DateTimePicker::make('done_at'),
                Select::make('status')
                    ->options(['done' => 'Done', 'pending' => 'Pending', 'expired' => 'Expired', 'cancelled' => 'Cancelled'])
                    ->default('pending')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
