<x-filament-panels::page>
    {{ $this->content }}

    <div class="mt-6 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-base font-semibold text-gray-950 dark:text-white">
                {{ __('filament-mail-editor::filament-mail-editor.builder.heading') }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('filament-mail-editor::filament-mail-editor.builder.description') }}
            </p>
        </div>
        @livewire('email-builder', ['templateId' => $this->record->getKey()])
    </div>
</x-filament-panels::page>
