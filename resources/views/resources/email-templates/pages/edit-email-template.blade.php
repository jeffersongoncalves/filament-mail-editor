<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Standard Filament form for metadata --}}
        <x-filament-panels::form wire:submit="save">
            {{ $this->form }}

            <x-filament-panels::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament-panels::form>

        {{-- Email Builder Component --}}
        <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-base font-semibold text-gray-950 dark:text-white">Email Builder</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Drag and drop blocks to build your email template.</p>
            </div>
            @livewire('email-builder', ['templateId' => $record->getKey()])
        </div>
    </div>
</x-filament-panels::page>
