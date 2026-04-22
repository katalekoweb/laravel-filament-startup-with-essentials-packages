<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular(),

                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail')
                    ->copyable(),

                TextColumn::make('type')
                    ->label('Nível de Acesso')
                    ->badge() // Transforma em Badge
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'admin'      => 'Administrador',
                        'employee'   => 'Funcionário',
                        'technician' => 'Técnico',
                        'client'     => 'Cliente/Morador',
                        'manager'    => 'Gestor/Síndico', // Adicionado caso use manager
                        default      => $state,
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'admin'      => 'danger',  // Vermelho
                        'manager'    => 'info',    // Azul
                        'employee'   => 'warning', // Amarelo/Laranja
                        'technician' => 'gray',    // Cinza
                        'client'     => 'success', // Verde
                        default      => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('phone')
                    ->label('Telefone'),

                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
