<?php

namespace JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\Pages;

use Filament\Resources\Pages\CreateRecord;
use JeffersonGoncalves\FilamentMailEditor\Resources\SavedEmailBlocks\SavedEmailBlockResource;
use JeffersonGoncalves\MailEditor\Support\BlockRegistry;

class CreateSavedEmailBlock extends CreateRecord
{
    protected static string $resource = SavedEmailBlockResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['props']) && ! empty($data['type'])) {
            $block = app(BlockRegistry::class)->find($data['type']);
            $data['props'] = $block?->defaultProps() ?? [];
        }

        return $data;
    }
}
