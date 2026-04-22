<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto'),

                TextColumn::make('name')
                    ->label('Unidade')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('section.name')
                    ->label('Seção')
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Tipo')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'house' => 'Residencial',
                        'room' => 'Comercial',
                        'leisure' => 'Lazer',
                        'event' => 'Eventos',
                        'sport' => 'Desporto',
                        'parking' => 'Vaga',
                    })
                    ->badge()
                    ->color('gray'),

                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'available' => 'success',   // Verde
                        'rented' => 'info',        // Azul
                        'sold' => 'gray',          // Cinza
                        'maintenance' => 'danger', // Vermelho
                        'reserved' => 'warning',   // Amarelo
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'available' => 'Disponível',
                        'rented' => 'Alugado',
                        'sold' => 'Vendido',
                        'maintenance' => 'Em Manutenção',
                        'reserved' => 'Reservado',
                    }),

                TextColumn::make('sell_price')
                    ->label('Venda')
                    ->money('AOA') // Formata como moeda (Kwanza)
                    ->sortable(),

                TextColumn::make('month_rent_price')
                    ->label('Aluguer mensal')
                    ->sortable(),

                TextColumn::make('daily_rent_price')
                    ->label('Preço da diária')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Status')
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
                \Filament\Tables\Filters\SelectFilter::make('section_id')
                    ->label('Filtrar por Seção')
                    ->relationship(
                        'section',
                        'name',
                        fn($query) =>
                        $query->where('tenant_id', auth()->user()->tenant_id)
                    ),
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
