@php
    $record = $getRecord();
    $registry = app(\JeffersonGoncalves\MailEditor\Support\BlockRegistry::class);
    $instance = $registry->find($record->type);
    $html = $instance?->render($record->props ?? []) ?? '';
@endphp

<div class="fi-me-block-preview" wire:ignore>
    <div class="fi-me-block-preview-stage">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; margin: 0 auto; background: #ffffff;">
            {!! $html !!}
        </table>
    </div>
</div>
