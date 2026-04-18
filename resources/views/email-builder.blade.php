<div
    x-data="emailBuilder()"
    class="email-builder flex flex-col h-full"
>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js" wire:ignore></script>
    <script id="block-catalog-data" type="application/json" wire:ignore>@json($availableBlocks)</script>
    {{-- Toolbar --}}
    <div class="email-builder__toolbar flex items-center gap-3 p-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">
        <div class="flex-1 grid grid-cols-3 gap-3">
            <input
                type="text"
                x-model="name"
                wire:model.blur="name"
                placeholder="Template name..."
                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm"
            />
            <input
                type="text"
                x-model="subject"
                wire:model.blur="subject"
                placeholder="Email subject..."
                class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm"
            />
            <div class="flex gap-2">
                <select
                    wire:model.live="category"
                    class="block flex-1 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm"
                >
                    <option value="transactional">Transactional</option>
                    <option value="marketing">Marketing</option>
                    <option value="notification">Notification</option>
                </select>
                {{-- Theme Selector --}}
                <select
                    wire:model.live="activeTheme"
                    x-on:change="$wire.applyTheme($event.target.value)"
                    class="block w-28 rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-sm"
                    title="Apply Theme"
                >
                    @foreach ($themes as $themeKey)
                        <option value="{{ $themeKey }}">{{ ucfirst($themeKey) }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex items-center gap-2">
            {{-- Undo/Redo --}}
            <button
                type="button"
                x-on:click="undo()"
                :disabled="!history.length"
                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-30 transition"
                title="Undo (Ctrl+Z)"
            >
                <x-filament::icon icon="heroicon-m-arrow-uturn-left" class="h-4 w-4" />
            </button>
            <button
                type="button"
                x-on:click="redo()"
                :disabled="!future.length"
                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 disabled:opacity-30 transition"
                title="Redo (Ctrl+Y)"
            >
                <x-filament::icon icon="heroicon-m-arrow-uturn-right" class="h-4 w-4" />
            </button>

            <div class="w-px h-6 bg-gray-200 dark:bg-gray-700"></div>

            {{-- Quality Check --}}
            <button
                wire:click="runQualityCheck"
                type="button"
                class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 transition"
                title="Quality Check"
            >
                <x-filament::icon icon="heroicon-m-clipboard-document-check" class="h-4 w-4" />
            </button>

            <button
                wire:click="save"
                type="button"
                class="inline-flex items-center gap-1.5 rounded-lg bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-500 transition"
            >
                <x-filament::icon icon="heroicon-m-check" class="h-4 w-4" />
                Save
            </button>
            <button
                wire:click="export"
                type="button"
                class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                title="Export HTML (Ctrl+E)"
            >
                <x-filament::icon icon="heroicon-m-arrow-down-tray" class="h-4 w-4" />
                HTML
            </button>
            <button
                wire:click="exportPlaintext"
                type="button"
                class="inline-flex items-center gap-1.5 rounded-lg bg-gray-100 dark:bg-gray-700 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                title="Export Plaintext"
            >
                <x-filament::icon icon="heroicon-m-document-text" class="h-4 w-4" />
                TXT
            </button>
        </div>
    </div>

    {{-- Main Layout --}}
    <div class="email-builder__main flex flex-1 overflow-hidden">
        {{-- Sidebar Left: Block Palette + Library --}}
        <div class="email-builder__sidebar-left w-[200px] flex-shrink-0 border-r border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 overflow-y-auto">
            {{-- Tabs --}}
            <div class="flex border-b border-gray-200 dark:border-gray-700">
                <button
                    type="button"
                    x-on:click="sidebarTab = 'blocks'"
                    :class="sidebarTab === 'blocks' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'"
                    class="flex-1 px-2 py-2 text-xs font-medium border-b-2 transition"
                >
                    Blocks
                </button>
                <button
                    type="button"
                    x-on:click="sidebarTab = 'library'"
                    :class="sidebarTab === 'library' ? 'border-primary-500 text-primary-600' : 'border-transparent text-gray-500'"
                    class="flex-1 px-2 py-2 text-xs font-medium border-b-2 transition"
                >
                    Library
                </button>
            </div>

            {{-- Blocks Tab --}}
            <div x-show="sidebarTab === 'blocks'" class="p-3">
                @php
                    $categories = [
                        'structure' => 'Structure',
                        'content' => 'Content',
                        'marketing' => 'Marketing',
                    ];
                @endphp

                @foreach ($categories as $catKey => $catLabel)
                    <div class="mb-4">
                        <h4 class="text-[10px] font-bold uppercase text-gray-400 dark:text-gray-500 mb-1.5 tracking-wider">{{ $catLabel }}</h4>
                        <div class="space-y-1">
                            @foreach ($availableBlocks as $type => $block)
                                @if ($block['category'] === $catKey)
                                    <button
                                        type="button"
                                        x-on:click="addBlock('{{ $type }}')"
                                        class="w-full flex items-center gap-2 px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                                        title="{{ $block['label'] }}"
                                    >
                                        <x-filament::icon :icon="$block['icon']" class="h-4 w-4 text-gray-400" />
                                        <span class="truncate">{{ $block['label'] }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Library Tab --}}
            <div x-show="sidebarTab === 'library'" class="p-3">
                <h4 class="text-[10px] font-bold uppercase text-gray-400 dark:text-gray-500 mb-2 tracking-wider">Saved Components</h4>
                @forelse ($savedBlocks as $saved)
                    <button
                        type="button"
                        wire:click="addSavedBlock({{ $saved->id }})"
                        class="w-full flex items-center gap-2 px-2 py-1.5 text-xs text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition mb-1"
                        title="{{ $saved->description ?? $saved->name }}"
                    >
                        <x-filament::icon icon="heroicon-o-bookmark" class="h-4 w-4 text-gray-400" />
                        <span class="truncate">{{ $saved->name }}</span>
                        <span class="text-[9px] text-gray-400 ml-auto">{{ $saved->type }}</span>
                    </button>
                @empty
                    <p class="text-xs text-gray-400 text-center py-4">No saved components yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Canvas --}}
        <div class="email-builder__canvas flex-1 overflow-y-auto bg-gray-100 dark:bg-gray-800 p-6">
            <div
                id="blocks-canvas"
                class="max-w-[620px] mx-auto min-h-[200px] bg-white dark:bg-gray-900 rounded-lg shadow-sm"
            >
                <template x-if="blocks.length === 0">
                    <div class="flex flex-col items-center justify-center py-20 text-gray-400 dark:text-gray-500">
                        <x-filament::icon icon="heroicon-o-inbox" class="h-12 w-12 mb-3" />
                        <p class="text-sm">Click a block to add it here</p>
                    </div>
                </template>

                <template x-for="(block, index) in blocks" :key="block.id">
                    <div
                        class="email-builder__block group relative border-2 border-transparent hover:border-primary-300 dark:hover:border-primary-600 transition cursor-pointer"
                        :class="{ 'border-primary-500 dark:border-primary-400': selectedId === block.id }"
                        x-on:click="selectedId = block.id"
                    >
                        {{-- Block toolbar --}}
                        <div class="absolute -top-3 right-2 hidden group-hover:flex items-center gap-1 bg-white dark:bg-gray-800 rounded shadow-sm border border-gray-200 dark:border-gray-700 px-1 py-0.5 z-10">
                            <button
                                type="button"
                                class="drag-handle p-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-grab"
                                title="Drag to reorder"
                            >
                                <x-filament::icon icon="heroicon-m-bars-2" class="h-3.5 w-3.5" />
                            </button>
                            <button
                                type="button"
                                x-on:click.stop="duplicateBlock(block.id)"
                                class="p-0.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                title="Duplicate (Ctrl+D)"
                            >
                                <x-filament::icon icon="heroicon-m-document-duplicate" class="h-3.5 w-3.5" />
                            </button>
                            <button
                                type="button"
                                x-on:click.stop="$wire.saveBlockAsComponent(block.id, blockCatalog[block.type]?.label ?? block.type)"
                                class="p-0.5 text-yellow-500 hover:text-yellow-600"
                                title="Save to library"
                            >
                                <x-filament::icon icon="heroicon-m-bookmark" class="h-3.5 w-3.5" />
                            </button>
                            <button
                                type="button"
                                x-on:click.stop="removeBlock(block.id)"
                                class="p-0.5 text-red-400 hover:text-red-600"
                                title="Delete (Del)"
                            >
                                <x-filament::icon icon="heroicon-m-trash" class="h-3.5 w-3.5" />
                            </button>
                        </div>

                        {{-- Block type label --}}
                        <div class="absolute -top-3 left-2 hidden group-hover:block bg-primary-500 text-white text-[10px] font-semibold px-1.5 py-0.5 rounded z-10">
                            <span x-text="blockCatalog[block.type]?.label ?? block.type"></span>
                        </div>

                        {{-- Block content placeholder --}}
                        <div class="p-3 min-h-[40px]">
                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                <span x-text="blockCatalog[block.type]?.label ?? block.type" class="font-medium"></span>
                                <template x-if="block.type === 'heading' || block.type === 'paragraph'">
                                    <span class="text-gray-400 truncate max-w-[300px]" x-text="block.props?.text || block.props?.html || ''"></span>
                                </template>
                                <template x-if="block.type === 'button'">
                                    <span class="text-gray-400" x-text="block.props?.text || ''"></span>
                                </template>
                                <template x-if="block.type === 'image'">
                                    <span class="text-gray-400 truncate max-w-[300px]" x-text="block.props?.alt || block.props?.src || ''"></span>
                                </template>
                                <template x-if="block.type === 'coupon'">
                                    <span class="text-gray-400" x-text="block.props?.code || ''"></span>
                                </template>
                                <template x-if="block.type === 'product-card'">
                                    <span class="text-gray-400 truncate max-w-[300px]" x-text="block.props?.name || ''"></span>
                                </template>
                                <template x-if="block.type === 'countdown'">
                                    <span class="text-gray-400" x-text="block.props?.end_date || 'No date set'"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Sidebar Right: Props Panel --}}
        <div class="email-builder__sidebar-right w-[280px] flex-shrink-0 border-l border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-y-auto">
            <template x-if="!selectedBlock">
                <div class="p-4 text-sm text-gray-400 dark:text-gray-500 text-center mt-8">
                    <x-filament::icon icon="heroicon-o-cursor-arrow-ripple" class="h-8 w-8 mx-auto mb-2" />
                    Select a block to edit its properties
                </div>
            </template>

            <template x-if="selectedBlock">
                <div class="p-4">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white" x-text="blockCatalog[selectedBlock.type]?.label ?? selectedBlock.type"></h3>
                        <button
                            type="button"
                            x-on:click="selectedId = null"
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                        >
                            <x-filament::icon icon="heroicon-m-x-mark" class="h-4 w-4" />
                        </button>
                    </div>

                    <div class="space-y-3" x-data="blockPropsEditor()">
                        <template x-for="(field, key) in getFieldsForType(selectedBlock.type)" :key="key">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1" x-text="field.label"></label>

                                <template x-if="field.type === 'text'">
                                    <input
                                        type="text"
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:input="updateProp(field.key, $event.target.value)"
                                        :maxlength="field.maxLength ?? undefined"
                                        :placeholder="field.placeholder ?? ''"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                    />
                                </template>

                                <template x-if="field.type === 'textarea'">
                                    <textarea
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:input="updateProp(field.key, $event.target.value)"
                                        rows="3"
                                        :placeholder="field.placeholder ?? ''"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                    ></textarea>
                                </template>

                                <template x-if="field.type === 'color'">
                                    <div class="flex items-center gap-2">
                                        <input
                                            type="color"
                                            :value="selectedBlock.props[field.key] ?? field.default ?? '#000000'"
                                            x-on:input="updateProp(field.key, $event.target.value)"
                                            class="h-8 w-10 rounded border border-gray-300 dark:border-gray-600 cursor-pointer"
                                        />
                                        <input
                                            type="text"
                                            :value="selectedBlock.props[field.key] ?? field.default ?? '#000000'"
                                            x-on:input="updateProp(field.key, $event.target.value)"
                                            class="block flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                        />
                                    </div>
                                </template>

                                <template x-if="field.type === 'select'">
                                    <select
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:change="updateProp(field.key, $event.target.value)"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                    >
                                        <template x-for="option in field.options" :key="option.value">
                                            <option :value="option.value" x-text="option.label" :selected="(selectedBlock.props[field.key] ?? field.default) === option.value"></option>
                                        </template>
                                    </select>
                                </template>

                                <template x-if="field.type === 'number'">
                                    <input
                                        type="number"
                                        :value="selectedBlock.props[field.key] ?? field.default ?? 0"
                                        x-on:input="updateProp(field.key, parseFloat($event.target.value))"
                                        :min="field.min ?? undefined"
                                        :max="field.max ?? undefined"
                                        :step="field.step ?? 1"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                    />
                                </template>

                                <template x-if="field.type === 'toggle'">
                                    <button
                                        type="button"
                                        x-on:click="updateProp(field.key, !(selectedBlock.props[field.key] ?? field.default ?? false))"
                                        :class="(selectedBlock.props[field.key] ?? field.default ?? false) ? 'bg-primary-600' : 'bg-gray-300 dark:bg-gray-600'"
                                        class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full transition-colors"
                                    >
                                        <span
                                            :class="(selectedBlock.props[field.key] ?? field.default ?? false) ? 'translate-x-4' : 'translate-x-0'"
                                            class="pointer-events-none relative inline-block h-5 w-5 transform rounded-full bg-white shadow transition-transform"
                                        ></span>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Variables Panel --}}
            @if (count($detectedVariables ?? []) > 0)
                <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-3">
                        <x-filament::icon icon="heroicon-m-variable" class="h-3.5 w-3.5 inline -mt-0.5" />
                        Merge Variables
                    </h3>
                    <div class="space-y-2">
                        @foreach ($detectedVariables as $var)
                            <div>
                                <label class="block text-[10px] font-mono text-gray-500 dark:text-gray-400 mb-0.5">@{{ {{ $var }} }}</label>
                                <input
                                    type="text"
                                    wire:model.blur="testVariables.{{ $var }}"
                                    placeholder="Test value..."
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                                />
                            </div>
                        @endforeach
                    </div>
                    <label class="flex items-center gap-2 mt-3 text-xs text-gray-500 dark:text-gray-400">
                        <input type="checkbox" wire:model.live="previewWithVariables" class="rounded border-gray-300 dark:border-gray-600" />
                        Preview with variables
                    </label>
                </div>
            @endif

            {{-- Test Email --}}
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <h3 class="text-xs font-semibold uppercase text-gray-500 dark:text-gray-400 mb-3">
                    <x-filament::icon icon="heroicon-m-paper-airplane" class="h-3.5 w-3.5 inline -mt-0.5" />
                    Send Test Email
                </h3>
                <div class="flex gap-2">
                    <input
                        type="email"
                        wire:model="testEmailAddress"
                        placeholder="email@example.com"
                        class="block flex-1 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white text-xs"
                    />
                    <button
                        wire:click="sendTestEmail"
                        type="button"
                        class="inline-flex items-center rounded-md bg-gray-100 dark:bg-gray-700 px-3 py-1.5 text-xs font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition"
                    >
                        Send
                    </button>
                </div>
            </div>

            {{-- Keyboard Shortcuts --}}
            <div class="border-t border-gray-200 dark:border-gray-700 p-4">
                <details class="text-xs text-gray-400 dark:text-gray-500">
                    <summary class="cursor-pointer font-semibold uppercase tracking-wider">Shortcuts</summary>
                    <div class="mt-2 space-y-1">
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+Z</kbd> Undo</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+Y</kbd> Redo</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+S</kbd> Save</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+D</kbd> Duplicate</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+E</kbd> Export</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Ctrl+P</kbd> Preview</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Del</kbd> Remove block</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">&uarr;&darr;</kbd> Move block</div>
                        <div><kbd class="font-mono bg-gray-100 dark:bg-gray-700 px-1 rounded">Esc</kbd> Deselect</div>
                    </div>
                </details>
            </div>
        </div>
    </div>

    {{-- Preview Panel --}}
    <div class="email-builder__preview border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 dark:bg-gray-900">
            <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Preview:</span>
            @foreach (['gmail' => 'Gmail', 'outlook' => 'Outlook', 'apple' => 'Apple Mail', 'mobile' => 'Mobile'] as $clientKey => $clientLabel)
                <button
                    type="button"
                    wire:click="$set('previewClient', '{{ $clientKey }}')"
                    class="px-3 py-1 text-xs rounded-full transition"
                    :class="$wire.previewClient === '{{ $clientKey }}' ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 font-medium' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                >
                    {{ $clientLabel }}
                </button>
            @endforeach
        </div>
        <div class="bg-gray-200 dark:bg-gray-800 p-4 flex justify-center" style="max-height: 500px; overflow-y: auto;">
            <div
                :style="$wire.previewClient === 'mobile' ? 'width: 375px' : 'width: 660px'"
                class="transition-all duration-300"
            >
                <iframe
                    id="preview-iframe"
                    class="w-full bg-white rounded shadow-sm border-0"
                    style="min-height: 400px;"
                    x-ref="previewIframe"
                ></iframe>
            </div>
        </div>
    </div>
</div>
