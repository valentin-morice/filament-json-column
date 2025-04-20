<div x-data="{
        id: {{ \Illuminate\Support\Js::from($uniqid) }},
        jsonError: $persist(false).as(`jsonError-${this.id}`)
    }"
     id="toggle-component"
     x-init="if (jsonError) jsonError = false"
     x-on:json-error-triggered.window="if ($event.detail === id) jsonError = true"
     x-on:json-error-cleared.window="if ($event.detail === id) jsonError = false">
    <div class="container flex justify-between">
        <div style="display: flex; font-size: 0.875rem; line-height: 1.25rem;">
            <div class="control"
                 x-data="{ id: $id('display-toggle') }"
                 x-on:click="!jsonError && (display = 'viewer')"
                 x-bind:style="jsonError && { opacity: 0.5 }"
                 x-bind:class="{
                    'active': display === 'viewer',
                 }"
            >
                <div>Viewer</div>
            </div>
            <div class="control"
                 x-on:click="!jsonError && (display = 'editor')"
                 x-bind:class="{
                    'active': display === 'editor',
                 }"
            >
                <div>Editor</div>
            </div>
        </div>
    </div>
</div>
