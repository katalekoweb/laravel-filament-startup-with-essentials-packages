<?php

namespace App\Filament\Resources\Sections\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SectionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalhes da Seção / Bloco')
                ->description('As seções organizam as unidades (casas, apartamentos ou áreas de lazer).')
                ->schema([

                    TextInput::make('name')
                        ->label('Nome da Seção')
                        ->placeholder('Ex: Bloco A, Torre Sul, Área de Lazer')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, $set) => $set('slug', Str::slug($state))),

                    TextInput::make('slug')
                        ->label('Slug')
                        ->unique(ignoreRecord: true)
                        ->required()
                        ->readOnly(),

                    TextInput::make('manager_phone')
                        ->label('Telefone do Responsável')
                        ->tel()
                        ->placeholder('+244 ...'),

                    Textarea::make('about')
                        ->label('Descrição/Observações')
                        ->placeholder('Descreva o que compõe esta seção...')
                        ->columnSpanFull(),

                    FileUpload::make('photo')
                        ->label('Foto da Seção')
                        ->image()
                        ->directory('sections'),

                    Toggle::make('is_active')
                        ->label('Seção Ativa')
                        ->default(true),
                ])->columns(2)->columnSpanFull(),
            ]);
    }
}
