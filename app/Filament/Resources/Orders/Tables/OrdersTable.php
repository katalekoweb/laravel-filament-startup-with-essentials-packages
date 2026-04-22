<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('ocupant.name')
                    ->label('Ocupante')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('unit.name')
                    ->label('Unidade')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'buy' => 'warning',
                        'rent' => 'info',
                    })
                    ->formatStateUsing(fn(string $state) => $state === 'buy' ? 'Compra' : 'Aluguer'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'gray',
                        'active' => 'success',
                        'converted' => 'info',
                        'cancelled' => 'danger',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'Pendente',
                        'active' => 'Ativo',
                        'converted' => 'Convertido',
                        'cancelled' => 'Cancelado',
                    }),

                TextColumn::make('created_at')
                    ->label('Data do Pedido')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options(['buy' => 'Compra', 'rent' => 'Aluguer']),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pendente',
                        'active' => 'Ativo',
                        'converted' => 'Convertido',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->recordActions([
                Action::make('converter_contrato')
                    ->label('Converter em Contrato')
                    ->icon('heroicon-m-check-badge')
                    ->color('success')
                    // Só aparece se o pedido estiver ativo ou pendente
                    ->visible(fn($record) => in_array($record->status, ['active', 'pending']))
                    ->requiresConfirmation()
                    ->modalHeading('Confirmar Conversão')
                    ->modalDescription('Ao confirmar, este pedido será marcado como convertido e o status da unidade será atualizado automaticamente. Deseja continuar?')
                    ->modalSubmitActionLabel('Sim, converter')
                    ->action(function ($record) {
                        // Usamos uma transação de DB para garantir que ou muda tudo ou não muda nada
                        DB::transaction(function () use ($record) {
                            // 1. Atualizar o status do Pedido
                            $record->update([
                                'status' => 'converted',
                            ]);

                            // 2. Definir o novo status da Unidade baseado no tipo do pedido
                            $novoStatusUnidade = ($record->type === 'buy') ? 'sold' : 'rented';

                            // 3. Atualizar a Unidade vinculada
                            $record->unit()->update([
                                'status' => $novoStatusUnidade,
                            ]);
                        });

                        Notification::make()
                            ->title('Pedido convertido com sucesso!')
                            ->body("A unidade {$record->unit->name} foi marcada como {$record->type}.")
                            ->success()
                            ->send();
                    }),
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
