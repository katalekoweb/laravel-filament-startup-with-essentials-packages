<?php

namespace App\Filament\Resources\Units\Schemas;

use App\Forms\Components\InputMoney;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identificação da Unidade')
                    ->description('Cadastre casas, apartamentos ou áreas comuns.')
                    ->schema([

                        Select::make('section_id')
                            ->label('Seção/Bloco')
                            ->relationship(
                                'section',
                                'name',
                                fn($query) =>
                                $query->where('tenant_id', request()->user()->tenant_id)
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('name')
                            ->label('Identificação (ex: Casa 01, Apto 102)')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->readOnly()
                            ->required(),

                        Select::make('category')
                            ->label('Tipo de Unidade')
                            ->options([
                                'house' => 'Residencial (Casa/Apto)',
                                'room' => 'Comercial (Sala/Escritório)',
                                'leisure' => 'Lazer (Piscina/Churrasqueira)',
                                'event' => 'Eventos (Salão/Conferência)',
                                'sport' => 'Desporto (Campo/Quadra)',
                                'parking' => 'Estacionamento',
                            ])
                            ->native(false)
                            ->required()
                            ->preload(),


                        Select::make('tipology')
                            ->label('Tipologia')
                            ->options([
                                't1' => 'T1',
                                't2' => 'T2',
                                't3' => 'T3',
                                't4' => 'T4',
                                't5' => 'T5',
                                't5+' => 'T5+',
                            ])
                            // Lógica: Só aparece se a categoria for 'house'
                            ->visible(fn(Get $get) => $get('category') === 'house')
                            ->native(false),

                        Select::make('resources')
                            ->label('Recursos / Comodidades')
                            ->multiple() // Habilita a seleção múltipla
                            ->relationship('resources', 'name') // Nome da relação no Model e campo a exibir
                            ->preload() // Carrega as opções ao abrir (bom se não houverem milhares)
                            ->searchable()
                            ->hint('Selecione extras como AC, Piscina, Gerador...')
                            ->createOptionForm([ // Permite criar um recurso novo ali mesmo se não existir
                                TextInput::make('name')
                                    ->required(),
                            ]),

                        Select::make('status')
                            ->label('Estado Atual')
                            ->options([
                                'available' => 'Disponível',
                                'rented' => 'Alugado',
                                'sold' => 'Vendido/Comprado',
                                'maintenance' => 'Em Manutenção',
                                'reserved' => 'Reservado',
                            ])
                            ->native(false)
                            ->required()
                            ->default('available'),

                    ])->columns(3)->columnSpanFull(),

                Section::make('Financeiro e Status')
                    ->schema([

                        InputMoney::make('sell_price')
                            ->label('Preço de Venda'),

                        InputMoney::make('month_rent_price')
                            ->label('Aluguer Mensal'),

                        InputMoney::make('daily_rent_price')
                            ->label('Preço da Diária'),

                        FileUpload::make('photo')
                            ->label('Foto Principal')
                            ->image()
                            ->directory('units'),

                        FileUpload::make('photo2')
                            ->label('Foto 2')
                            ->image()
                            ->directory('units'),

                        FileUpload::make('photo3')
                            ->label('Foto 3')
                            ->image()
                            ->directory('units'),

                        Toggle::make('is_active')
                            ->label('Disponível/Ativo')
                            ->default(true)
                            ->columnSpanFull(),
                    ])->columns(3)->columnSpanFull(),
            ]);
    }
}
