<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
>
    <div x-data="{
            state: {{ \Illuminate\Support\Js::from($getState()) }},
            get prettyJson() {
                try {
                    return window.prettyPrint(JSON.parse(this.state));
                } catch {
                    return window.prettyPrint(this.state);
                }
            }
        }"
        @style([
                 'border-radius: 0.5rem;' => true,
                 'box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);',
                 'overflow: hidden;'
             ]) class="master">
        <div style="font-size: 0.875rem; line-height: 1.25rem; overflow: auto;">
            <pre class="prettyjson" x-html="prettyJson" style="height: 100%"></pre>
        </div>
    </div>
</x-dynamic-component>
