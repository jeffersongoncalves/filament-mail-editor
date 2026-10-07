<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use JeffersonGoncalves\FilamentMailEditor\Support\EnumPresenter;
use JeffersonGoncalves\MailEditor\Enums\TemplateCategory;

class EmailTemplateForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.template_details'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, ?string $old, ?string $context = null): void {
                                if ($context === 'edit') {
                                    return;
                                }
                                $set('slug', Str::slug($state ?? ''));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('subject')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.subject'))
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('preheader')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.preheader'))
                            ->maxLength(90)
                            ->helperText(__('filament-mail-editor::filament-mail-editor.fields.preheader_helper')),
                    ])->columns(2),
                Section::make(__('filament-mail-editor::filament-mail-editor.sections.settings'))
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.category'))
                            ->options(EnumPresenter::options(TemplateCategory::class))
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.template_category'))
                            ->relationship('templateCategory', 'name')
                            ->searchable()
                            ->preload()
                            ->placeholder(__('filament-mail-editor::filament-mail-editor.fields.none')),
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('filament-mail-editor::filament-mail-editor.fields.is_active'))
                            ->default(true),
                    ])->columns(2),
            ]);
    }
}
