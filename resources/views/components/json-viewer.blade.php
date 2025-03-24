@props(['height', 'uniqid'])

<div x-show="display === 'viewer'" style="font-size: 0.875rem; line-height: 1.25rem; height:{{ $height }}; overflow: auto;">
    <pre class="prettyjson" x-html="prettyJson" style="height: 100%"></pre>
</div>
