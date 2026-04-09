<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use JeffersonGoncalves\FilamentMailEditor\Enums\TemplateCategory;

class EmailTemplateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Template Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subject')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('preheader')
                            ->maxLength(90)
                            ->helperText('Short preview text shown in email clients (max 90 characters).'),
                    ])->columns(2),
                Section::make('Settings')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->options(TemplateCategory::class)
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
