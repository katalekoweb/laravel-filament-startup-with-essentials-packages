<?php

namespace App\Filament\Resources\Sections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->rounded(),

                TextColumn::make('name')
                    ->label('Nome da Seção')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('units_count')
                    ->label('Total de unidades')
                    ->counts("units")
                    ->searchable()
                    ->sortable(),

                TextColumn::make('manager_phone')
                    ->label('Contacto')
                    ->toggleable(),

                // Badge para mostrar se está ativa de forma editável na lista
                ToggleColumn::make('is_active')
                    ->label('Status'),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y')
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
