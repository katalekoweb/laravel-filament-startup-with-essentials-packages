<?php

namespace App\Filament\Resources\Tenants\Schemas;

use App\Models\City;
use App\Models\Section;
use App\Models\State;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class TenantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                ComponentsSection::make('Informações do Condomínio')
                    ->description('Gerencie os dados principais e a localização da unidade.')
                    ->schema([
                        // Linha 1: Localização Dinâmica
                        Select::make('country_id')
                            ->label('País')
                            ->relationship('country', 'name')
                            ->live() // Faz o formulário reagir à mudança instantaneamente
                            ->afterStateUpdated(fn($set) => $set('state_id', null)) // Limpa o estado se mudar o país
                            ->searchable()
                            ->preload()
                            ->required(),

                        // 2. Seleção de Estado (Depende do País)
                        Select::make('state_id')
                            ->label('Província/Estado')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->live()
                            ->afterStateUpdated(fn($set) => $set('city_id', null)) // Limpa a cidade se mudar o estado
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn(Get $get) => ! $get('country_id')), // Fica desativado até escolher o país

                        // 3. Seleção de Cidade (Depende do Estado)
                        Select::make('city_id')
                            ->label('Cidade')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn(Get $get) => ! $get('state_id')), // Fica desativado até escolher o estado

                        // Linha 2: Identificação
                        TextInput::make('name')
                            ->label('Nome do Condomínio')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(
                                fn(string $operation, $state, $set) =>
                                $operation === 'create' ? $set('slug', \Illuminate\Support\Str::slug($state)) : null
                            ),

                        TextInput::make('slug')
                            ->label('Slug/Link Único')
                            ->unique(ignoreRecord: true)
                            ->required(),

                        TextInput::make('doc')
                            ->label('Documento/NIF')
                            ->placeholder('Ex: 500123456'),

                        // Linha 3: Contatos
                        TextInput::make('email')
                            ->label('E-mail de Contato')
                            ->email()
                            ->required(),

                        TextInput::make('phone')
                            ->label('Telefone')
                            ->tel(),

                        TextInput::make('address')
                            ->label('Endereço Completo'),

                        // Linha 4: Descrição e Mídia
                        Textarea::make('about')
                            ->label('Sobre o Condomínio')
                            ->columnSpanFull(),

                        FileUpload::make('photo')
                            ->label('Logotipo/Foto')
                            ->image()
                            ->directory('condos'),

                        Toggle::make('is_active')
                            ->label('Status Ativo')
                            ->default(true)
                            ->required(),
                    ])->columns(3)->columnSpanFull()

            ]);
    }
}
