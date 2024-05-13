<x-dynamic-component
        :component="$getFieldWrapperView()"
        :field="$field"
    >
    <div class="master"
         @style([
            'border-radius: 0.5rem 0.5rem 0 0;' => $getMode() === '',
            'border-radius: 0' => $getMode() === 'editor',
            'border-radius: 0.5rem;' => $getMode() === 'viewer',
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
    @if($getMode() === '')
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
            <div style="font-size: 0.875rem; line-height: 1.25rem;"
                 x-show="display === 'viewer'"
            >
                <pre class="prettyjson" x-html="prettyJson"></span>
            </div>
            <div x-show="display === 'editor'" style="padding: 0.25rem;">
                <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
                     x-init="$nextTick(() => {
                    const options = {
                        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                        history: true,
                        onChange: function(){
                        },
                        onChangeJSON: function(json){
                            state=JSON.stringify(json);
                        },
                        onChangeText: function(jsonString){
                            state=jsonString;
                        },
                        onValidationError: function (errors) {
                            errors.forEach((error) => {
                              switch (error.type) {
                                case 'validation': // schema validation error
                                  break;
                                case 'error':  // json parse error
                                    console.log(error.message);
                                  break;
                              }
                            })
                        }
                    };
                    if(typeof json_editor !== 'undefined'){
                        json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(JSON.stringify(state)));
                    } else {
                        let json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(JSON.stringify(state)));
                    }
                 })"
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="min-height: 30vh;height:{{ $getEditorHeight() }}"></div>
                </div>
            </div>
    @elseif($getMode() === 'editor')
            <div style="padding: 0.25rem;">
                <div style="width: 100%; font-size: 0.875rem; line-height: 1.25rem;"
                     x-init="$nextTick(() => {
                    const options = {
                        modes: ['code', 'form', 'text', 'tree', 'view', 'preview'],
                        history: true,
                        onChange: function(){
                        },
                        onChangeJSON: function(json){
                            state=JSON.stringify(json);
                        },
                        onChangeText: function(jsonString){
                            state=jsonString;
                        },
                        onValidationError: function (errors) {
                            errors.forEach((error) => {
                              switch (error.type) {
                                case 'validation': // schema validation error
                                  break;
                                case 'error':  // json parse error
                                    console.log(error.message);
                                  break;
                              }
                            })
                        }
                    };
                    if(typeof json_editor !== 'undefined'){
                        json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(JSON.stringify(state)));
                    } else {
                        let json_editor = new JSONEditor($refs.editor, options);
                        json_editor.set(JSON.parse(JSON.stringify(state)));
                    }
                 })"
                     x-cloak
                     wire:ignore>
                    <div x-ref="editor" class="w-full ace_editor"
                         style="min-height: 30vh;height:{{ $getEditorHeight() }}"></div>
                </div>
            </div>
    @elseif($getMode() === 'viewer')
            <div style="font-size: 0.875rem; line-height: 1.25rem;">
                <pre class="prettyjson" x-html="prettyJson"></pre>
            </div>
    @endif
    </div>
    <style>
        .active {
            box-shadow:0 -3px 0 0 {{ $getAccent() }} inset;
        }
    </style>
</x-dynamic-component>
