<x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
    >
    <div class="master"
         @style([
            'border-radius: 0.5rem 0.5rem 0 0;' => !$getEditorMode() && !$getViewerMode(),
            'border-radius: 0' => $getEditorMode() === true,
            'border-radius: 0.5rem;' => $getViewerMode() === true,
            'box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);',
            'overflow: hidden;'
         ])
         x-data="{
                       state: $wire.entangle('{{ $getStatePath() }}'),
                       get prettyJson() {
                           try {
                             json = JSON.parse(JSON.parse(JSON.stringify(this.state)))
                           } catch {
                             json = JSON.parse(JSON.stringify(this.state))
                           }
                           return window.prettyPrint(json)
                       },
                       display: 'viewer'
                    }"
    >
    @if(! $getEditorMode() && ! $getViewerMode())
            <div class="container">
                <div style="display: flex; font-size: 0.875rem; line-height: 1.25rem;">
                    <div class="control"
                         x-on:click="display = 'viewer'"
                         x-bind:class="display === 'viewer' ? 'active' : ''"
                    >
                        <div>Viewer</div>
                    </div>
                    <div class="control"
                         x-on:click="display = 'editor'"
                         x-bind:class="display === 'editor' ? 'active' : ''"
                    >
                        <div>Editor</div>
                    </div>
                </div>
            </div>
            <div style="font-size: 0.875rem; line-height: 1.25rem; height:{{ $getViewerHeight() }}; overflow: auto;"
                 x-show="display === 'viewer'"
            >
                <pre class="prettyjson" x-html="prettyJson" style="height: 100%"></pre>
            </div>
            <div x-show="display === 'editor'" style="padding: 0.25rem;">
                <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
                     x-data="{
                        internalChange: false,
                        resetInternalChange() {
                            setTimeout(() => {
                                this.internalChange = false;
                            }, 100);
                        },
                        initializeEditor(value) {
                            const options = {
                                modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                                history: true,
                                onChange: function(){
                                },
                                onChangeJSON: function(json){
                                    this.internalChange = true;
                                    state = json;
                                    this.resetInternalChange();  // Debounced reset
                                },
                                onChangeText: (jsonString) => {
                                    this.internalChange = true;
                                    state = jsonString;
                                    this.resetInternalChange();  // Debounced reset
                                },
                                onValidationError: function (errors) {
                                    errors.forEach((error) => {
                                        switch (error.type) {
                                            case 'validation':
                                                // schema validation error
                                                break;
                                            case 'error':
                                                // json parse error
                                                console.log(error.message);
                                                break;
                                        }
                                    });
                                }
                            };

                            // If editor already exists, re-initialize it with updated state
                            if (typeof json_editor !== 'undefined') {
                                json_editor.destroy();
                            }


                            json_editor = new JSONEditor($refs.editor, options);
                            if (typeof value === 'string') {
                                json_editor.set(JSON.parse(value));
                            } else {
                                json_editor.set(value);
                            }
                        }
                     }"
                     x-init="
                     initializeEditor(state)
                     $watch('state', (value) => {
                        // Only reinitialize the editor if change is external
                        if (!internalChange) {
                            initializeEditor(value);
                        }
                    })
                     "
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="height:{{ $getEditorHeight() }}"></div>
                </div>
            </div>
    @elseif($getEditorMode())
            <div style="padding: 0.25rem;">
                <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
                     x-data="{
                        internalChange: false,
                        resetInternalChange() {
                            setTimeout(() => {
                                this.internalChange = false;
                            }, 100);
                        },
                        initializeEditor(value) {
                            const options = {
                                modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                                history: true,
                                onChange: function(){
                                },
                                onChangeJSON: function(json){
                                    this.internalChange = true;
                                    state = json;
                                    this.resetInternalChange();  // Debounced reset
                                },
                                onChangeText: (jsonString) => {
                                    this.internalChange = true;
                                    state = jsonString;
                                    this.resetInternalChange();  // Debounced reset
                                },
                                onValidationError: function (errors) {
                                    errors.forEach((error) => {
                                        switch (error.type) {
                                            case 'validation':
                                                // schema validation error
                                                break;
                                            case 'error':
                                                // json parse error
                                                console.log(error.message);
                                                break;
                                        }
                                    });
                                }
                            };

                            // If editor already exists, re-initialize it with updated state
                            if (typeof json_editor !== 'undefined') {
                                json_editor.destroy();
                            }


                            json_editor = new JSONEditor($refs.editor, options);
                            if (typeof value === 'string') {
                                json_editor.set(JSON.parse(value));
                            } else {
                                json_editor.set(value);
                            }
                        }
                     }"
                     x-init="
                     initializeEditor(state)
                     $watch('state', (value) => {
                        // Only reinitialize the editor if change is external
                        if (!internalChange) {
                            initializeEditor(value);
                        }
                    })
                    "
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="height:{{ $getEditorHeight() }}"></div>
                </div>
            </div>
    @elseif($getViewerMode())
            <div style="font-size: 0.875rem; line-height: 1.25rem; height:{{ $getViewerHeight() }}; overflow: auto;">
                <pre class="prettyjson" x-html="prettyJson" style="height: 100%"></pre>
            </div>
    @endif
    </div>
    <style>
        .active {
            box-shadow:0 -3px 0 0 {{ $getAccent() }} inset;
        }
    </style>
</x-dynamic-component>
