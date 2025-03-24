@props(['uniqid', 'height', 'modes'])

<div style="padding: 0.25rem;" x-show="display === 'editor'">
    <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
         x-id="['json-editor']"
         x-data="{
            id: {{ \Illuminate\Support\Js::from($uniqid) }},
            internalChange: false,
            resetInternalChange() {
                setTimeout(() => {
                    this.internalChange = false;
                }, 100);
            },
            initializeEditor(value) {
                const options = {
                    modes: {{ \Illuminate\Support\Js::from($modes) }},
                    history: false,
                    onChange: function(){},
                    onChangeJSON: function(json){
                        this.internalChange = true;
                        state = json;
                        this.resetInternalChange();
                        $dispatch('json-error-cleared', id);
                    },
                    onChangeText: (jsonString) => {
                        this.internalChange = true;
                        state = jsonString;
                        this.resetInternalChange();
                        $dispatch('json-error-cleared', id);
                    },
                    onValidationError: function (errors) {
                        errors.forEach((error) => {
                            if (error.type === 'error') {
                                $dispatch('json-error-triggered', id);
                            }
                        })
                    }
                };

                if (typeof window[$id('json-editor')] !== 'undefined') {
                    window[$id('json-editor')].destroy();
                }

                window[$id('json-editor')] = new JSONEditor($refs[`editor-${this.id}`], options);
                window[$id('json-editor')].set(typeof value === 'string' ? JSON.parse(value) : value);
            }
         }"
         x-init="
         initializeEditor(state)
         $watch('state', (value) => {
            if (!internalChange) {
                initializeEditor(value);
            }
        })
         "
         x-cloak
         wire:ignore>
        <div x-ref="editor-{{ $uniqid }}" class="w-full ace_editor" style="height:{{ $height }}"></div>
    </div>
</div>
