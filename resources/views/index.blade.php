<x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
    >
    @php
        $uniqid = uniqid();
    @endphp
    <div class="master"
         @style([
            'border-radius: 0.5rem 0.5rem 0 0;' => !$getEditorMode() && !$getViewerMode(),
            'border-radius: 0' => $getEditorMode() === true,
            'border-radius: 0.5rem;' => $getViewerMode() === true,
            'box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);',
            'overflow: hidden;'
         ])
         x-data="{
                       state{{ $uniqid }}: $wire.entangle('{{ $getStatePath() }}'),
                       get prettyJson() {
                           try {
                             json = JSON.parse(JSON.parse(JSON.stringify(this.state{{ $uniqid }})))
                           } catch {
                             json = JSON.parse(JSON.stringify(this.state{{ $uniqid }}))
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
                        internalChange{{ $uniqid }}: false,
                        resetinternalChange{{ $uniqid }}() {
                            setTimeout(() => {
                                this.internalChange{{ $uniqid }} = false;
                            }, 100);
                        },
                        initializeEditor{{ $uniqid }}(value) {
                            const options = {
                                modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                                history: true,
                                onChange: function(){
                                },
                                onChangeJSON: function(json){
                                    this.internalChange{{ $uniqid }} = true;
                                    state{{ $uniqid }} = json;
                                    this.resetinternalChange{{ $uniqid }}();  // Debounced reset
                                },
                                onChangeText: (jsonString) => {
                                    this.internalChange{{ $uniqid }} = true;
                                    state{{ $uniqid }} = jsonString;
                                    this.resetinternalChange{{ $uniqid }}();  // Debounced reset
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
                            if (typeof json_editor{{ $uniqid }} !== 'undefined') {
                                json_editor{{ $uniqid }}.destroy();
                            }


                            json_editor{{ $uniqid }} = new JSONEditor($refs.editor{{ $uniqid }}, options);
                            if (typeof value === 'string') {
                                json_editor{{ $uniqid }}.set(JSON.parse(value));
                            } else {
                                json_editor{{ $uniqid }}.set(value);
                            }
                        }
                     }"
                     x-init="
                     initializeEditor{{ $uniqid }}(state{{ $uniqid }})
                     $watch('state{{ $uniqid }}', (value) => {
                        // Only reinitialize the editor if change is external
                        if (!internalChange{{ $uniqid }}) {
                            initializeEditor{{ $uniqid }}(value);
                        }
                    })
                     "
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor{{ $uniqid }}" class="w-full ace_editor"
                         style="height:{{ $getEditorHeight() }}"></div>
                </div>
            </div>
    @elseif($getEditorMode())
            <div style="padding: 0.25rem;">
                <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
                     x-data="{
                        internalChange{{ $uniqid }}: false,
                        resetinternalChange{{ $uniqid }}() {
                            setTimeout(() => {
                                this.internalChange{{ $uniqid }} = false;
                            }, 100);
                        },
                        initializeEditor{{ $uniqid }}(value) {
                            const options = {
                                modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                                history: true,
                                onChange: function(){
                                },
                                onChangeJSON: function(json){
                                    this.internalChange{{ $uniqid }} = true;
                                    state{{ $uniqid }} = json;
                                    this.resetinternalChange{{ $uniqid }}();  // Debounced reset
                                },
                                onChangeText: (jsonString) => {
                                    this.internalChange{{ $uniqid }} = true;
                                    state{{ $uniqid }} = jsonString;
                                    this.resetinternalChange{{ $uniqid }}();  // Debounced reset
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

                            // If editor already exists, re-initialize it with updated state{{ $uniqid }}
                            if (typeof json_editor{{ $uniqid }} !== 'undefined') {
                                json_editor{{ $uniqid }}.destroy();
                            }


                            json_editor{{ $uniqid }} = new JSONEditor($refs.editor{{ $uniqid }}, options);
                            if (typeof value === 'string') {
                                json_editor{{ $uniqid }}.set(JSON.parse(value));
                            } else {
                                json_editor{{ $uniqid }}.set(value);
                            }
                        }
                     }"
                     x-init="
                     initializeEditor{{ $uniqid }}(state{{ $uniqid }})
                     $watch('state{{ $uniqid }}', (value) => {
                        // Only reinitialize the editor if change is external
                        if (!internalChange{{ $uniqid }}) {
                            initializeEditor{{ $uniqid }}(value);
                        }
                    })
                    "
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor{{ $uniqid }}" class="w-full ace_editor"
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
