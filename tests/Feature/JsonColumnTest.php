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
        ->toThrow(\Exception::class);
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

// Livewire Integration Tests
// Note: These tests are temporarily commented out due to compatibility issues 
// with Filament 4 beta and Livewire. They will be re-enabled once the beta is stable.

/*
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

    Livewire::test(FormTestComponent::class)
        ->fill(['data' => ['json' => '{"city":"Paris", "active":false, "count":5}']])
        ->call('save')
        ->assertHasNoFormErrors()
        ->assertSet('data.json', $expected);
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
*/
