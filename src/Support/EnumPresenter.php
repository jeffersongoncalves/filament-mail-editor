<?php

namespace JeffersonGoncalves\FilamentMailEditor\Support;

use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;

/**
 * The enums of jeffersongoncalves/laravel-mail-editor expose getLabel()/getColor()/getIcon() without
 * implementing Filament's HasLabel/HasColor/HasIcon contracts (the core package has no Filament dependency),
 * so Filament would fall back to raw values. This feeds those methods to selects and badges.
 */
final class EnumPresenter
{
    /**
     * @param  class-string<BackedEnum>  $enum
     * @return array<string|int, string>
     */
    public static function options(string $enum): array
    {
        $options = [];

        foreach ($enum::cases() as $case) {
            $options[$case->value] = method_exists($case, 'getLabel') ? $case->getLabel() : $case->name;
        }

        return $options;
    }

    /**
     * @template TComponent of TextColumn|TextEntry
     *
     * @param  TComponent  $component
     * @return TComponent
     */
    public static function badge(TextColumn|TextEntry $component): TextColumn|TextEntry
    {
        return $component
            ->badge()
            ->formatStateUsing(fn (mixed $state): mixed => $state instanceof BackedEnum && method_exists($state, 'getLabel') ? $state->getLabel() : $state)
            ->color(fn (mixed $state): ?string => $state instanceof BackedEnum && method_exists($state, 'getColor') ? $state->getColor() : null)
            ->icon(fn (mixed $state): ?string => $state instanceof BackedEnum && method_exists($state, 'getIcon') ? $state->getIcon() : null);
    }
}
