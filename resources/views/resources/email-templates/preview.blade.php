@php
    $record = $getRecord();
    $blocksJson = rawurlencode(json_encode($record->blocks ?? [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    $settingsJson = rawurlencode(json_encode($record->settings ?? (object) [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    $baseUrl = route('mail-editor.preview');
    $clients = [
        'gmail' => 'Gmail',
        'outlook' => 'Outlook',
        'apple' => 'Apple Mail',
        'mobile' => 'Mobile',
    ];
@endphp

<div
    x-data="{ client: 'gmail' }"
    class="fi-me-view-preview"
    wire:ignore
>
    <div class="fi-me-view-preview-clients">
        @foreach ($clients as $key => $label)
            <button
                type="button"
                x-on:click="client = '{{ $key }}'"
                :class="{ 'fi-me-preview-chip--active': client === '{{ $key }}' }"
                class="fi-me-preview-chip"
            >
                {{ $label }}
            </button>
        @endforeach
    </div>

    <div
        class="fi-me-view-preview-frame"
        :class="client === 'mobile' ? 'fi-me-view-preview-frame--mobile' : ''"
    >
        <iframe
            :src="'{{ $baseUrl }}?blocks={{ $blocksJson }}&settings={{ $settingsJson }}&client=' + client"
            class="fi-me-view-preview-iframe"
        ></iframe>
    </div>
</div>
