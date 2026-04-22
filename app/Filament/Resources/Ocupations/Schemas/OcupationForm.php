<?php

namespace App\Filament\Resources\Ocupations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class OcupationForm
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
                TextInput::make('ocupant_id')
                    ->required()
                    ->numeric(),
                TextInput::make('unit_id')
                    ->required()
                    ->numeric(),
                TextInput::make('order_id')
                    ->numeric(),
                Textarea::make('notes')
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->options(['buy' => 'Buy', 'rent' => 'Rent'])
                    ->default('rent')
                    ->required(),
                DatePicker::make('expire_at'),
                Select::make('status')
                    ->options(['active' => 'Active', 'pending' => 'Pending', 'expired' => 'Expired'])
                    ->default('active')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('period'),
            ]);
    }
}
