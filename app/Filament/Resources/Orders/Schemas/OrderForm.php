<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalhes do Pedido')
                    ->description('Vincule um ocupante a uma unidade específica.')
                    ->schema([
                        Select::make('ocupant_id')
                            ->label('Ocupante/Cliente')
                            ->relationship('ocupant', 'name', fn ($query) =>
                                $query->where('tenant_id', request()->user()->tenant_id)
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('unit_id')
                            ->label('Unidade')
                            ->relationship('unit', 'name', fn ($query) =>
                                $query->where('tenant_id', request()->user()->tenant_id)
                                      ->where('is_active', true)
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('type')
                            ->label('Tipo de Negócio')
                            ->options([
                                'buy' => 'Compra',
                                'rent' => 'Aluguer',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Select::make('period')
                            ->label('Período de Aluguer')
                            ->options([
                                'daily' => 'Diário',
                                'monthly' => 'Mensal',
                            ])
                            ->visible(fn (Get $get) => $get('type') === 'rent')
                            ->required()
                            ->native(false),

                        Select::make('status')
                            ->label('Status do Pedido')
                            ->options([
                                'pending' => 'Pendente',
                                'active' => 'Ativo',
                                'converted' => 'Convertido em Contrato',
                                'cancelled' => 'Cancelado',
                            ])
                            ->default('pending')
                            ->required()
                            ->native(false),

                        Textarea::make('notes')
                            ->label('Notas/Observações')
                            ->columnSpanFull()
                            ->placeholder('Detalhes sobre a negociação...'),

                        Toggle::make('is_active')
                            ->label('Pedido Ativo')
                            ->default(true),
                    ])->columns(2)->columnSpanFull()

            ]);
    }
}
