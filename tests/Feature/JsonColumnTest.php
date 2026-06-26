<?php

use Livewire\Livewire;
use ValentinMorice\FilamentJsonColumn\JsonColumn;
use ValentinMorice\FilamentJsonColumn\JsonInfolist;
use ValentinMorice\FilamentJsonColumn\Tests\Support\FormTestComponent;

it('can instantiate JsonColumn', function () {
    $component = JsonColumn::make('test');

    expect($component)->toBeInstanceOf(JsonColumn::class);
    expect($component->getName())->toBe('test');
});

it('can instantiate JsonInfolist', function () {
    $component = JsonInfolist::make('test');

    expect($component)->toBeInstanceOf(JsonInfolist::class);
    expect($component->getName())->toBe('test');
});

it('can configure editor options', function () {
    $component = JsonColumn::make('test')
        ->editorOnly()
        ->editorHeight(500)
        ->accent('#ff0000');

    expect($component->getEditorMode())->toBeTrue();
    expect($component->getEditorHeight())->toBe('500px');
    expect($component->getAccent())->toBe('#ff0000');
});

it('can configure viewer options', function () {
    $component = JsonColumn::make('test')
        ->viewerOnly()
        ->viewerHeight(400);

    expect($component->getViewerMode())->toBeTrue();
    expect($component->getViewerHeight())->toBe('400px');
});

it('can configure editor modes', function () {
    $modes = ['code', 'tree'];
    $component = JsonColumn::make('test')->editorModes($modes);

    expect($component->getModes())->toBe($modes);
});

it('throws exception with invalid editor modes', function () {
    expect(fn () => JsonColumn::make('test')->editorModes(['invalid_mode']))
        ->toThrow(Exception::class);
});

it('has correct default values', function () {
    $component = JsonColumn::make('test');

    expect($component->getEditorMode())->toBeFalse();
    expect($component->getViewerMode())->toBeFalse();
    expect($component->getAccent())->toBe('slateblue');
    expect($component->getEditorHeight())->toBe('300px');
    expect($component->getViewerHeight())->toBe('308px');
    expect($component->getModes())->toBe(['code', 'form', 'text', 'tree', 'view', 'preview']);
});

// Livewire / Filament rendering integration tests (Filament 5 + Livewire 4).

it('renders in livewire component', function () {
    Livewire::test(FormTestComponent::class)
        ->assertSee('json');
});

it('shows toggle by default', function () {
    Livewire::test(FormTestComponent::class)
        ->assertSee('toggle-component');
});

it('always outputs an array', function () {
    $expected = [
        'city' => 'Paris',
        'active' => false,
        'count' => 5,
    ];

    // The live form state stays a JSON string; the package only converts it back to
    // an array on dehydration (so the model receives a clean array). Assert on the
    // dehydrated state captured during save() rather than the live property.
    Livewire::test(FormTestComponent::class)
        ->fill(['data' => ['json' => '{"city":"Paris", "active":false, "count":5}']])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertSet('saved.json', $expected);
});

it('fails when state is not a valid json string', function () {
    Livewire::test(FormTestComponent::class)
        ->fill(['data' => ['json' => 'invalid_json']])
        ->call('save')
        ->assertHasFormErrors(['json']);
});

it('does not show toggle on editor or viewer mode', function () {
    Livewire::test(FormTestComponent::class, [
        'options' => [
            'editorOnly' => true,
        ],
    ])
        ->assertDontSee('toggle-component');

    Livewire::test(FormTestComponent::class, [
        'options' => [
            'viewerOnly' => true,
        ],
    ])
        ->assertDontSee('toggle-component');
});

it('renders the default english toggle labels', function () {
    Livewire::test(FormTestComponent::class)
        ->assertSee('Viewer')
        ->assertSee('Editor');
});

it('translates the toggle labels for the active locale', function () {
    app('translator')->addLines([
        'json-column.viewer' => 'Mirador',
        'json-column.editor' => 'Redactor',
    ], 'xx', 'filament-json-column');

    app()->setLocale('xx');

    Livewire::test(FormTestComponent::class)
        ->assertSee('Mirador')
        ->assertSee('Redactor')
        ->assertDontSee('Viewer');
});
