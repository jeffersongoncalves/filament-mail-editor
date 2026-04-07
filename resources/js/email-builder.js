document.addEventListener('alpine:init', () => {
    window.blockDefaults = {};

    Alpine.data('emailBuilder', () => ({
        blocks: Alpine.$wire ? Alpine.$wire.entangle('blocks') : [],
        name: Alpine.$wire ? Alpine.$wire.entangle('name') : '',
        subject: Alpine.$wire ? Alpine.$wire.entangle('subject') : '',
        selectedId: null,
        blockCatalog: {},
        _sortable: null,

        get selectedBlock() {
            return this.blocks.find(b => b.id === this.selectedId) ?? null;
        },

        init() {
            // Load block catalog from the page data
            const catalogEl = document.getElementById('block-catalog-data');
            if (catalogEl) {
                try {
                    this.blockCatalog = JSON.parse(catalogEl.textContent);
                    Object.keys(this.blockCatalog).forEach(type => {
                        window.blockDefaults[type] = this.blockCatalog[type].defaultProps ?? {};
                    });
                } catch (e) {
                    console.error('Failed to parse block catalog:', e);
                }
            }

            // Watch blocks for preview updates
            this.$watch('blocks', () => {
                this.updatePreview();
            });

            // Initialize SortableJS when canvas is ready
            this.$nextTick(() => {
                this.initSortable();
            });
        },

        initSortable() {
            const canvas = document.getElementById('blocks-canvas');
            if (!canvas || !window.Sortable) return;

            this._sortable = Sortable.create(canvas, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'opacity-40',
                draggable: '.email-builder__block',
                onEnd: (e) => {
                    if (e.oldIndex === e.newIndex) return;
                    const moved = this.blocks.splice(e.oldIndex, 1)[0];
                    this.blocks.splice(e.newIndex, 0, moved);
                    this.syncToLivewire();
                },
            });
        },

        addBlock(type) {
            const defaults = window.blockDefaults[type] ?? {};
            const block = {
                id: 'b_' + Math.random().toString(36).slice(2, 9),
                type: type,
                props: JSON.parse(JSON.stringify(defaults)),
            };
            this.blocks.push(block);
            this.selectedId = block.id;
            this.$nextTick(() => this.syncToLivewire());
        },

        duplicateBlock(id) {
            const source = this.blocks.find(b => b.id === id);
            if (!source) return;

            const index = this.blocks.indexOf(source);
            const clone = {
                id: 'b_' + Math.random().toString(36).slice(2, 9),
                type: source.type,
                props: JSON.parse(JSON.stringify(source.props)),
            };
            this.blocks.splice(index + 1, 0, clone);
            this.selectedId = clone.id;
            this.syncToLivewire();
        },

        removeBlock(id) {
            this.blocks = this.blocks.filter(b => b.id !== id);
            if (this.selectedId === id) this.selectedId = null;
            this.syncToLivewire();
        },

        moveBlock(id, direction) {
            const index = this.blocks.findIndex(b => b.id === id);
            if (index < 0) return;
            const newIndex = index + direction;
            if (newIndex < 0 || newIndex >= this.blocks.length) return;

            const moved = this.blocks.splice(index, 1)[0];
            this.blocks.splice(newIndex, 0, moved);
            this.syncToLivewire();
        },

        syncToLivewire() {
            if (this.$wire) {
                this.$wire.syncBlocks(JSON.parse(JSON.stringify(this.blocks)));
            }
        },

        updatePreview() {
            const iframe = this.$refs?.previewIframe ?? document.getElementById('preview-iframe');
            if (!iframe) return;

            const client = this.$wire?.previewClient ?? 'gmail';
            const blocks = encodeURIComponent(JSON.stringify(this.blocks));
            const settings = encodeURIComponent(JSON.stringify(this.$wire?.settings ?? {}));
            const url = `/filament-mail-editor/preview?blocks=${blocks}&settings=${settings}&client=${client}`;

            iframe.src = url;
        },
    }));

    Alpine.data('blockPropsEditor', () => ({
        fieldDefinitions: {
            preheader: [
                { key: 'text', label: 'Preheader Text', type: 'textarea', maxLength: 90, placeholder: 'Preview text shown in inbox...' },
            ],
            header: [
                { key: 'logo_src', label: 'Logo URL', type: 'text', placeholder: 'https://...' },
                { key: 'logo_alt', label: 'Logo Alt Text', type: 'text' },
                { key: 'bg_color', label: 'Background Color', type: 'color', default: '#1A3A5C' },
                { key: 'web_link', label: 'View in Browser URL', type: 'text' },
                { key: 'align', label: 'Alignment', type: 'select', default: 'center', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
            ],
            hero: [
                { key: 'title', label: 'Title', type: 'text' },
                { key: 'subtitle', label: 'Subtitle', type: 'textarea' },
                { key: 'bg_color', label: 'Background Color', type: 'color', default: '#185FA5' },
                { key: 'bg_image', label: 'Background Image URL', type: 'text' },
                { key: 'overlay_opacity', label: 'Overlay Opacity', type: 'number', min: 0, max: 1, step: 0.1, default: 0.5 },
                { key: 'cta_text', label: 'CTA Text', type: 'text' },
                { key: 'cta_url', label: 'CTA URL', type: 'text' },
                { key: 'cta_bg_color', label: 'CTA Background', type: 'color', default: '#ffffff' },
                { key: 'cta_text_color', label: 'CTA Text Color', type: 'color', default: '#185FA5' },
                { key: 'align', label: 'Alignment', type: 'select', default: 'center', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
            ],
            heading: [
                { key: 'text', label: 'Text', type: 'text' },
                { key: 'level', label: 'Level', type: 'select', default: 'h2', options: [
                    { value: 'h1', label: 'H1' }, { value: 'h2', label: 'H2' }, { value: 'h3', label: 'H3' }, { value: 'h4', label: 'H4' },
                ]},
                { key: 'color', label: 'Color', type: 'color', default: '#1a1a1a' },
                { key: 'font_size', label: 'Font Size (px)', type: 'number', min: 10, max: 60 },
                { key: 'align', label: 'Alignment', type: 'select', default: 'left', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
                { key: 'font_family', label: 'Font Family', type: 'select', default: 'Arial, sans-serif', options: [
                    { value: 'Arial, sans-serif', label: 'Arial' }, { value: 'Georgia, serif', label: 'Georgia' },
                    { value: 'Verdana, sans-serif', label: 'Verdana' }, { value: 'Times New Roman, serif', label: 'Times New Roman' },
                ]},
            ],
            paragraph: [
                { key: 'html', label: 'Content (HTML)', type: 'textarea' },
                { key: 'color', label: 'Text Color', type: 'color', default: '#555555' },
                { key: 'font_size', label: 'Font Size (px)', type: 'number', default: 14, min: 10, max: 30 },
                { key: 'line_height', label: 'Line Height', type: 'number', default: 1.7, min: 1, max: 3, step: 0.1 },
                { key: 'align', label: 'Alignment', type: 'select', default: 'left', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
            ],
            button: [
                { key: 'text', label: 'Button Text', type: 'text' },
                { key: 'url', label: 'URL', type: 'text', placeholder: 'https://...' },
                { key: 'bg_color', label: 'Background', type: 'color', default: '#378ADD' },
                { key: 'text_color', label: 'Text Color', type: 'color', default: '#ffffff' },
                { key: 'border_radius', label: 'Border Radius (px)', type: 'number', default: 4, min: 0, max: 50 },
                { key: 'align', label: 'Alignment', type: 'select', default: 'center', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
                { key: 'width', label: 'Width', type: 'select', default: 'auto', options: [
                    { value: 'auto', label: 'Auto' }, { value: 'full', label: 'Full Width' },
                ]},
                { key: 'font_size', label: 'Font Size (px)', type: 'number', default: 14, min: 10, max: 24 },
                { key: 'padding', label: 'Padding', type: 'text', default: '12px 28px' },
            ],
            image: [
                { key: 'src', label: 'Image URL', type: 'text', placeholder: 'https://...' },
                { key: 'alt', label: 'Alt Text', type: 'text' },
                { key: 'link', label: 'Link URL', type: 'text' },
                { key: 'width', label: 'Width', type: 'text', default: '100%' },
                { key: 'align', label: 'Alignment', type: 'select', default: 'center', options: [
                    { value: 'left', label: 'Left' }, { value: 'center', label: 'Center' }, { value: 'right', label: 'Right' },
                ]},
                { key: 'border_radius', label: 'Border Radius (px)', type: 'number', default: 0, min: 0, max: 50 },
            ],
            divider: [
                { key: 'color', label: 'Color', type: 'color', default: '#e8e8e8' },
                { key: 'thickness', label: 'Thickness (px)', type: 'number', default: 1, min: 1, max: 10 },
                { key: 'width', label: 'Width', type: 'text', default: '100%' },
                { key: 'style', label: 'Style', type: 'select', default: 'solid', options: [
                    { value: 'solid', label: 'Solid' }, { value: 'dashed', label: 'Dashed' }, { value: 'dotted', label: 'Dotted' },
                ]},
            ],
            spacer: [
                { key: 'height', label: 'Height (px)', type: 'number', default: 24, min: 4, max: 100 },
                { key: 'mobile_height', label: 'Mobile Height (px)', type: 'number', default: 12, min: 4, max: 100 },
            ],
            testimonial: [
                { key: 'quote', label: 'Quote', type: 'textarea' },
                { key: 'author', label: 'Author', type: 'text' },
                { key: 'role', label: 'Role/Title', type: 'text' },
                { key: 'avatar_src', label: 'Avatar URL', type: 'text' },
                { key: 'accent_color', label: 'Accent Color', type: 'color', default: '#378ADD' },
            ],
            alert: [
                { key: 'type', label: 'Type', type: 'select', default: 'info', options: [
                    { value: 'info', label: 'Info' }, { value: 'warning', label: 'Warning' },
                    { value: 'error', label: 'Error' }, { value: 'success', label: 'Success' },
                ]},
                { key: 'text', label: 'Text', type: 'textarea' },
                { key: 'bg_color', label: 'Background (auto if empty)', type: 'color' },
                { key: 'text_color', label: 'Text Color (auto if empty)', type: 'color' },
                { key: 'border_color', label: 'Border Color (auto if empty)', type: 'color' },
            ],
            'two-columns': [
                { key: 'left_content', label: 'Left Content (HTML)', type: 'textarea' },
                { key: 'right_content', label: 'Right Content (HTML)', type: 'textarea' },
                { key: 'ratio', label: 'Column Ratio', type: 'select', default: '50-50', options: [
                    { value: '50-50', label: '50/50' }, { value: '60-40', label: '60/40' }, { value: '40-60', label: '40/60' },
                ]},
                { key: 'gap', label: 'Gap (px)', type: 'number', default: 16, min: 0, max: 40 },
                { key: 'bg_color_left', label: 'Left BG Color', type: 'color' },
                { key: 'bg_color_right', label: 'Right BG Color', type: 'color' },
                { key: 'stack_mobile', label: 'Stack on Mobile', type: 'toggle', default: true },
            ],
            footer: [
                { key: 'address', label: 'Address', type: 'textarea' },
                { key: 'unsubscribe_url', label: 'Unsubscribe URL', type: 'text', placeholder: '{{unsubscribe_url}}' },
                { key: 'unsubscribe_text', label: 'Unsubscribe Text', type: 'text', default: 'Unsubscribe' },
                { key: 'web_version_url', label: 'Web Version URL', type: 'text' },
                { key: 'copyright', label: 'Copyright', type: 'text' },
                { key: 'bg_color', label: 'Background', type: 'color', default: '#f8f9fa' },
                { key: 'text_color', label: 'Text Color', type: 'color', default: '#999999' },
                { key: 'font_size', label: 'Font Size (px)', type: 'number', default: 11, min: 9, max: 16 },
            ],
        },

        getFieldsForType(type) {
            return this.fieldDefinitions[type] ?? [];
        },

        updateProp(key, value) {
            const builder = Alpine.$data(this.$el.closest('[x-data*="emailBuilder"]'));
            if (!builder?.selectedBlock) return;

            builder.selectedBlock.props[key] = value;

            // Debounced sync to Livewire
            clearTimeout(this._syncTimer);
            this._syncTimer = setTimeout(() => {
                if (builder.$wire) {
                    builder.$wire.updateBlockProps(builder.selectedBlock.id, builder.selectedBlock.props);
                }
                builder.updatePreview();
            }, 250);
        },

        _syncTimer: null,
    }));
});
