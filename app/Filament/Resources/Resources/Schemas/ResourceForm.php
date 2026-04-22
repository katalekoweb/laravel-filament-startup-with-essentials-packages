<?php

namespace App\Filament\Resources\Resources\Schemas;

use App\Models\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;

class ResourceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make()->schema([
                    TextInput::make('name')
                        ->required(),
                    Textarea::make('description')
                        ->columnSpanFull(),
                    Toggle::make('is_active')
                        ->required()->default(1),
                ])
            ]);
    }
}
