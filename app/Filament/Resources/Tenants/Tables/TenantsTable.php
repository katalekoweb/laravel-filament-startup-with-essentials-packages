<?php

namespace App\Filament\Resources\Tenants\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TenantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('city.name') // Exibe o nome da cidade em vez do ID
                    ->label('Cidade')
                    ->sortable(),

                TextColumn::make('email')
                    ->label('E-mail'),

                TextColumn::make('phone')
                    ->label('Telefone'),

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
                //
            ])
            ->recordActions([
                Action::make('vincular')
                    ->label(fn($record) => Auth::user()->tenant_id === $record->id ? 'Desvincular' : 'Vincular-me')
                    ->icon(fn($record) => Auth::user()->tenant_id === $record->id ? 'heroicon-m-link-slash' : 'heroicon-m-link')
                    ->color(fn($record) => Auth::user()->tenant_id === $record->id ? 'danger' : 'success')
                    ->visible(fn() => Auth::user()->type === 'admin') // Apenas visível para Admin do sistema
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $user = Auth::user();

                        if ($user->tenant_id === $record->id) {
                            // Lógica para Desvincular
                            $user->update(['tenant_id' => null]);

                            Notification::make()
                                ->title('Desvinculado com sucesso')
                                ->warning()
                                ->send();
                        } else {
                            // Lógica para Vincular
                            $user->update(['tenant_id' => $record->id]);

                            Notification::make()
                                ->title('Vinculado ao condomínio: ' . $record->name)
                                ->success()
                                ->send();
                        }
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
