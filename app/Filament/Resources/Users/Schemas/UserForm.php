<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make('Informações Pessoais')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome Completo')
                        ->required()
                        ->maxLength(255),

                    Select::make('type')
                        ->label('Tipo de Utilizador')
                        ->options([
                            'admin' => 'Administrador (Geral)',
                            'employee' => 'Funcionário',
                            'technician' => 'Técnico',
                            'client' => 'Cliente/Morador',
                        ])
                        ->required()
                        ->native(false),

                    TextInput::make('email')
                        ->label('E-mail')
                        ->email()
                        ->unique(ignoreRecord: true),

                    TextInput::make('password')
                        ->label('Palavra-passe')
                        ->password()
                        ->required(fn ($livewire) => $livewire instanceof CreateRecord) // Obrigatório apenas na criação
                        ->dehydrated(fn ($state) => filled($state)) // Só envia se for preenchido
                        ->revealable(),
                ])->columns(2),

            Section::make('Contacto e Endereço')
                ->schema([
                    TextInput::make('phone')
                        ->label('Telefone Principal')
                        ->tel(),
                    TextInput::make('phone2')
                        ->label('Telefone Alternativo')
                        ->tel(),
                    TextInput::make('address')
                        ->label('Endereço')
                        ->columnSpanFull(),
                ])->columns(2),

            Section::make('Documentos e Fotos')
                ->description('Carregue os documentos de identificação')
                ->schema([
                    FileUpload::make('photo')
                        ->label('Foto de Perfil')
                        ->image()
                        ->avatar()
                        ->directory('users/photos'),

                    Grid::make(2)->schema([
                        FileUpload::make('doc_front_image')
                            ->label('Documento (Frente)')
                            ->image()
                            ->directory('users/docs'),

                        FileUpload::make('doc_verse_image')
                            ->label('Documento (Verso)')
                            ->image()
                            ->directory('users/docs'),
                    ]),
                ]),

            Toggle::make('is_active')
                ->label('Conta Ativa')
                ->default(true),
        ]);
    }
}
