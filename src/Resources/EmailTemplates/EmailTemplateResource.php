<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates;

use Filament\Forms\Form;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas\EmailTemplateForm;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Schemas\EmailTemplateInfolist;
use JeffersonGoncalves\FilamentMailEditor\Resources\EmailTemplates\Tables\EmailTemplatesTable;
use JeffersonGoncalves\MailEditor\Models\EmailTemplate;

class EmailTemplateResource extends Resource
{
    protected static ?string $model = EmailTemplate::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup(): ?string
    {
        return __('filament-mail-editor::filament-mail-editor.navigation.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament-mail-editor::filament-mail-editor.resource.email_template.plural_model_label');
    }

    public static function form(Form $form): Form
    {
        return EmailTemplateForm::configure($form);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return EmailTemplateInfolist::configure($infolist);
    }

    public static function table(Table $table): Table
    {
        return EmailTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmailTemplates::route('/'),
            'create' => Pages\CreateEmailTemplate::route('/create'),
            'view' => Pages\ViewEmailTemplate::route('/{record}'),
            'edit' => Pages\EditEmailTemplate::route('/{record}/edit'),
            'build' => Pages\BuildEmailTemplate::route('/{record}/build'),
        ];
    }
}
