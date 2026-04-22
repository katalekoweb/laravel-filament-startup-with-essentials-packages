<?php

namespace App\Filament\Resources\Finances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FinanceForm
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
                TextInput::make('title')
                    ->required(),
                Select::make('type')
                    ->options(['income' => 'Income', 'expense' => 'Expense'])
                    ->default('income')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('paid')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('missing')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('fine')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('number')
                    ->required()
                    ->numeric()
                    ->default(1),
                DatePicker::make('expires_at'),
                Toggle::make('is_carnet')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
