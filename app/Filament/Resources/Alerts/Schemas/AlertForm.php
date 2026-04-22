<?php

namespace App\Filament\Resources\Alerts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AlertForm
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
                TextInput::make('title')
                    ->required(),
                Textarea::make('message')
                    ->columnSpanFull(),
                TextInput::make('channel')
                    ->required()
                    ->default('app_email'),
                Toggle::make('is_sent')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
