<div
    x-data="emailBuilder($wire)"
    class="fi-me-builder"
>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js" wire:ignore></script>
    <script id="block-catalog-data" type="application/json" wire:ignore>@json($availableBlocks)</script>

    {{-- Toolbar --}}
    <div class="fi-me-toolbar">
        <div class="fi-me-toolbar-inputs">
            <input
                type="text"
                x-model="name"
                wire:model.blur="name"
                placeholder="Template name..."
                class="fi-me-input"
            />
            <input
                type="text"
                x-model="subject"
                wire:model.blur="subject"
                placeholder="Email subject..."
                class="fi-me-input"
            />
            <div class="fi-me-toolbar-select-group">
                <select
                    :value="$wire.category"
                    x-on:change="$wire.set('category', $event.target.value)"
                    class="fi-me-select"
                >
                    @foreach (\JeffersonGoncalves\FilamentMailEditor\Enums\TemplateCategory::cases() as $case)
                        <option value="{{ $case->value }}">{{ $case->getLabel() }}</option>
                    @endforeach
                </select>
                <select
                    :value="$wire.activeTheme"
                    x-on:change="$wire.set('activeTheme', $event.target.value); $wire.applyTheme($event.target.value)"
                    class="fi-me-select fi-me-toolbar-theme"
                    title="Apply Theme"
                >
                    @foreach ($themes as $themeSlug => $themeLabel)
                        <option value="{{ $themeSlug }}">{{ $themeLabel }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="fi-me-toolbar-actions">
            <button type="button" x-on:click="undo()" :disabled="!history.length" class="fi-me-btn-icon" title="Undo (Ctrl+Z)">
                <x-filament::icon icon="heroicon-m-arrow-uturn-left" />
            </button>
            <button type="button" x-on:click="redo()" :disabled="!future.length" class="fi-me-btn-icon" title="Redo (Ctrl+Y)">
                <x-filament::icon icon="heroicon-m-arrow-uturn-right" />
            </button>

            <div class="fi-me-toolbar-divider"></div>

            <button wire:click="runQualityCheck" type="button" class="fi-me-btn-icon" title="Quality Check">
                <x-filament::icon icon="heroicon-m-clipboard-document-check" />
            </button>

            <button wire:click="save" type="button" class="fi-me-btn fi-me-btn--primary">
                <x-filament::icon icon="heroicon-m-check" />
                Save
            </button>
            <button wire:click="export" type="button" class="fi-me-btn fi-me-btn--secondary" title="Export HTML (Ctrl+E)">
                <x-filament::icon icon="heroicon-m-arrow-down-tray" />
                HTML
            </button>
            <button wire:click="exportPlaintext" type="button" class="fi-me-btn fi-me-btn--secondary fi-me-btn--sm" title="Export Plaintext">
                <x-filament::icon icon="heroicon-m-document-text" />
                TXT
            </button>
        </div>
    </div>

    {{-- Main Layout --}}
    <div class="fi-me-main">
        {{-- Sidebar Left: Palette + Library --}}
        <div class="fi-me-sidebar fi-me-sidebar--left">
            <div class="fi-me-tabs">
                <button
                    type="button"
                    x-on:click="sidebarTab = 'blocks'"
                    :class="{ 'fi-me-tab--active': sidebarTab === 'blocks' }"
                    class="fi-me-tab"
                >Blocks</button>
                <button
                    type="button"
                    x-on:click="sidebarTab = 'library'"
                    :class="{ 'fi-me-tab--active': sidebarTab === 'library' }"
                    class="fi-me-tab"
                >Library</button>
            </div>

            {{-- Blocks Tab --}}
            <div x-show="sidebarTab === 'blocks'" class="fi-me-section--sm">
                @php
                    $categories = [
                        'structure' => 'Structure',
                        'content' => 'Content',
                        'marketing' => 'Marketing',
                    ];
                @endphp

                @foreach ($categories as $catKey => $catLabel)
                    <div class="fi-me-category">
                        <h4 class="fi-me-category-heading">{{ $catLabel }}</h4>
                        <div class="fi-me-palette-list">
                            @foreach ($availableBlocks as $type => $block)
                                @if ($block['category'] === $catKey)
                                    <button
                                        type="button"
                                        x-on:click="addBlock('{{ $type }}')"
                                        class="fi-me-block-btn"
                                        title="{{ $block['label'] }}"
                                    >
                                        <x-filament::icon :icon="$block['icon']" class="fi-me-block-btn-icon" />
                                        <span class="fi-me-block-btn-label">{{ $block['label'] }}</span>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Library Tab --}}
            <div x-show="sidebarTab === 'library'" class="fi-me-section--sm">
                <h4 class="fi-me-category-heading">Saved Components</h4>
                @forelse ($savedBlocks as $saved)
                    <button
                        type="button"
                        wire:click="addSavedBlock({{ $saved->id }})"
                        class="fi-me-block-btn"
                        title="{{ $saved->description ?? $saved->name }}"
                    >
                        <x-filament::icon icon="heroicon-o-bookmark" class="fi-me-block-btn-icon" />
                        <span class="fi-me-block-btn-label">{{ $saved->name }}</span>
                        <span class="fi-me-block-btn-type">{{ $saved->type }}</span>
                    </button>
                @empty
                    <p class="fi-me-empty-hint">No saved components yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Canvas --}}
        <div class="fi-me-canvas">
            <div id="blocks-canvas" class="fi-me-canvas-frame" wire:ignore>
                <template x-if="blocks.length === 0">
                    <div class="fi-me-empty-state">
                        <x-filament::icon icon="heroicon-o-inbox" class="fi-me-empty-state-icon" />
                        <p class="fi-me-empty-state-text">Click a block to add it here</p>
                    </div>
                </template>

                <template x-for="(block, index) in blocks" :key="block.id">
                    <div
                        class="fi-me-block"
                        :class="{ 'fi-me-block--selected': selectedId === block.id }"
                        x-on:click="selectedId = block.id"
                    >
                        <div class="fi-me-block-toolbar">
                            <button type="button" class="fi-me-block-toolbar-btn drag-handle" title="Drag to reorder">
                                <x-filament::icon icon="heroicon-m-bars-2" />
                            </button>
                            <button type="button" x-on:click.stop="duplicateBlock(block.id)" class="fi-me-block-toolbar-btn" title="Duplicate (Ctrl+D)">
                                <x-filament::icon icon="heroicon-m-document-duplicate" />
                            </button>
                            <button
                                type="button"
                                x-on:click.stop="$wire.saveBlockAsComponent(block.id, blockCatalog[block.type]?.label ?? block.type)"
                                class="fi-me-block-toolbar-btn fi-me-block-toolbar-btn--bookmark"
                                title="Save to library"
                            >
                                <x-filament::icon icon="heroicon-m-bookmark" />
                            </button>
                            <button type="button" x-on:click.stop="removeBlock(block.id)" class="fi-me-block-toolbar-btn fi-me-block-toolbar-btn--danger" title="Delete (Del)">
                                <x-filament::icon icon="heroicon-m-trash" />
                            </button>
                        </div>

                        <div class="fi-me-block-label">
                            <span x-text="blockCatalog[block.type]?.label ?? block.type"></span>
                        </div>

                        <div class="fi-me-block-body">
                            <div class="fi-me-block-summary">
                                <span class="fi-me-block-summary-title" x-text="blockCatalog[block.type]?.label ?? block.type"></span>
                                <template x-if="block.type === 'heading' || block.type === 'paragraph'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.text || block.props?.html || ''"></span>
                                </template>
                                <template x-if="block.type === 'button'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.text || ''"></span>
                                </template>
                                <template x-if="block.type === 'image'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.alt || block.props?.src || ''"></span>
                                </template>
                                <template x-if="block.type === 'coupon'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.code || ''"></span>
                                </template>
                                <template x-if="block.type === 'product-card'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.name || ''"></span>
                                </template>
                                <template x-if="block.type === 'countdown'">
                                    <span class="fi-me-block-summary-preview" x-text="block.props?.end_date || 'No date set'"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        {{-- Sidebar Right: Props Panel --}}
        <div class="fi-me-sidebar fi-me-sidebar--right">
            <template x-if="!selectedBlock">
                <div class="fi-me-props-empty">
                    <x-filament::icon icon="heroicon-o-cursor-arrow-ripple" class="fi-me-props-empty-icon" />
                    Select a block to edit its properties
                </div>
            </template>

            <template x-if="selectedBlock">
                <div class="fi-me-props-body">
                    <div class="fi-me-props-header">
                        <h3 class="fi-me-props-title" x-text="blockCatalog[selectedBlock.type]?.label ?? selectedBlock.type"></h3>
                        <button type="button" x-on:click="selectedId = null" class="fi-me-props-close">
                            <x-filament::icon icon="heroicon-m-x-mark" />
                        </button>
                    </div>

                    <div class="fi-me-fields" x-data="blockPropsEditor()">
                        <template x-for="(field, key) in getFieldsForType(selectedBlock.type)" :key="key">
                            <div>
                                <label class="fi-me-field-label" x-text="field.label"></label>

                                <template x-if="field.type === 'text'">
                                    <input
                                        type="text"
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:input="updateProp(field.key, $event.target.value)"
                                        :maxlength="field.maxLength ?? undefined"
                                        :placeholder="field.placeholder ?? ''"
                                        class="fi-me-input fi-me-input--sm"
                                    />
                                </template>

                                <template x-if="field.type === 'textarea'">
                                    <textarea
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:input="updateProp(field.key, $event.target.value)"
                                        rows="3"
                                        :placeholder="field.placeholder ?? ''"
                                        class="fi-me-textarea fi-me-textarea--sm"
                                    ></textarea>
                                </template>

                                <template x-if="field.type === 'color'">
                                    <div class="fi-me-color-group">
                                        <input
                                            type="color"
                                            :value="selectedBlock.props[field.key] ?? field.default ?? '#000000'"
                                            x-on:input="updateProp(field.key, $event.target.value)"
                                            class="fi-me-color-input"
                                        />
                                        <input
                                            type="text"
                                            :value="selectedBlock.props[field.key] ?? field.default ?? '#000000'"
                                            x-on:input="updateProp(field.key, $event.target.value)"
                                            class="fi-me-input fi-me-input--sm"
                                        />
                                    </div>
                                </template>

                                <template x-if="field.type === 'select'">
                                    <select
                                        :value="selectedBlock.props[field.key] ?? field.default ?? ''"
                                        x-on:change="updateProp(field.key, $event.target.value)"
                                        class="fi-me-select fi-me-select--sm"
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
                                        class="fi-me-input fi-me-input--sm"
                                    />
                                </template>

                                <template x-if="field.type === 'toggle'">
                                    <button
                                        type="button"
                                        x-on:click="updateProp(field.key, !(selectedBlock.props[field.key] ?? field.default ?? false))"
                                        :class="{ 'fi-me-toggle--on': (selectedBlock.props[field.key] ?? field.default ?? false) }"
                                        class="fi-me-toggle"
                                    >
                                        <span class="fi-me-toggle-thumb"></span>
                                    </button>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Variables Panel --}}
            @if (count($detectedVariables ?? []) > 0)
                <div class="fi-me-section fi-me-section--bordered">
                    <h3 class="fi-me-panel-heading">
                        <x-filament::icon icon="heroicon-m-variable" class="fi-me-panel-heading-icon" />
                        Merge Variables
                    </h3>
                    <div class="fi-me-variables-list">
                        @foreach ($detectedVariables as $var)
                            <div>
                                <label class="fi-me-variable-label">@{{ {{ $var }} }}</label>
                                <input
                                    type="text"
                                    wire:model.blur="testVariables.{{ $var }}"
                                    placeholder="Test value..."
                                    class="fi-me-input fi-me-input--sm"
                                />
                            </div>
                        @endforeach
                    </div>
                    <label class="fi-me-preview-toggle">
                        <input type="checkbox" wire:model.live="previewWithVariables" class="fi-me-checkbox" />
                        Preview with variables
                    </label>
                </div>
            @endif

            {{-- Test Email --}}
            <div class="fi-me-section fi-me-section--bordered">
                <h3 class="fi-me-panel-heading">
                    <x-filament::icon icon="heroicon-m-paper-airplane" class="fi-me-panel-heading-icon" />
                    Send Test Email
                </h3>
                <div class="fi-me-send-group">
                    <input
                        type="email"
                        wire:model="testEmailAddress"
                        placeholder="email@example.com"
                        class="fi-me-input fi-me-input--sm"
                    />
                    <button wire:click="sendTestEmail" type="button" class="fi-me-btn fi-me-btn--secondary fi-me-btn--sm">
                        Send
                    </button>
                </div>
            </div>

            {{-- Keyboard Shortcuts --}}
            <div class="fi-me-section fi-me-section--bordered">
                <details class="fi-me-shortcuts">
                    <summary class="fi-me-shortcuts-summary">Shortcuts</summary>
                    <div class="fi-me-shortcuts-list">
                        <div><kbd class="fi-me-kbd">Ctrl+Z</kbd> Undo</div>
                        <div><kbd class="fi-me-kbd">Ctrl+Y</kbd> Redo</div>
                        <div><kbd class="fi-me-kbd">Ctrl+S</kbd> Save</div>
                        <div><kbd class="fi-me-kbd">Ctrl+D</kbd> Duplicate</div>
                        <div><kbd class="fi-me-kbd">Ctrl+E</kbd> Export</div>
                        <div><kbd class="fi-me-kbd">Ctrl+P</kbd> Preview</div>
                        <div><kbd class="fi-me-kbd">Del</kbd> Remove block</div>
                        <div><kbd class="fi-me-kbd">&uarr;&darr;</kbd> Move block</div>
                        <div><kbd class="fi-me-kbd">Esc</kbd> Deselect</div>
                    </div>
                </details>
            </div>
        </div>
    </div>

    {{-- Preview Panel --}}
    <div class="fi-me-preview">
        <div class="fi-me-preview-bar">
            <span class="fi-me-preview-label">Preview:</span>
            @foreach (['gmail' => 'Gmail', 'outlook' => 'Outlook', 'apple' => 'Apple Mail', 'mobile' => 'Mobile'] as $clientKey => $clientLabel)
                <button
                    type="button"
                    wire:click="$set('previewClient', '{{ $clientKey }}')"
                    class="fi-me-preview-chip"
                    :class="{ 'fi-me-preview-chip--active': $wire.previewClient === '{{ $clientKey }}' }"
                >
                    {{ $clientLabel }}
                </button>
            @endforeach
        </div>
        <div class="fi-me-preview-stage">
            <div
                class="fi-me-preview-frame"
                :class="$wire.previewClient === 'mobile' ? 'fi-me-preview-frame--mobile' : 'fi-me-preview-frame--desktop'"
                wire:ignore
            >
                <iframe
                    id="preview-iframe"
                    class="fi-me-preview-iframe"
                    x-ref="previewIframe"
                ></iframe>
            </div>
        </div>
    </div>
</div>
