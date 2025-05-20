<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    @php
        $uniqid = uniqid();
        $is_default = ! $getEditorMode() && ! $getViewerMode();
        $display = $getViewerMode() ? 'viewer' : 'editor';
    @endphp

    <div class="fi-json-column master"
         @style([
             'border-radius: 0.5rem 0.5rem 0 0;' => $is_default,
             'border-radius: 0' => $getEditorMode() === true,
             'border-radius: 0.5rem;' => $getViewerMode() === true,
             'box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);',
             'overflow: hidden;'
         ])
         x-data="{
            id: {{ \Illuminate\Support\Js::from($uniqid) }},
            state: $wire.entangle({{ \Illuminate\Support\Js::from($getStatePath()) }}),
            get prettyJson() {
                try {
                    return window.prettyPrint(JSON.parse(this.state));
                } catch {
                    return window.prettyPrint(this.state);
                }
            },
            display: {{ \Illuminate\Support\Js::from($is_default ? 'viewer' : $display) }}
        }"
    >
        @if($is_default)
            @include('filament-json-column::components.json-toggle')
        @endif
        @if($is_default || $getEditorMode())
            @include('filament-json-column::components.json-editor-content',
                ['uniqid' => $uniqid, 'height' => $getEditorHeight(), 'modes' => $getModes()]
            )
        @endif
        @if($is_default || $getViewerMode())
            @include('filament-json-column::components.json-viewer',
                ['uniqid' => $uniqid, 'height' => $getViewerHeight()]
            )
        @endif
    </div>
    <style>
        .active {
            box-shadow:0 -3px 0 0 {{ $getAccent() }} inset;
        }
    </style>
</x-dynamic-component>
