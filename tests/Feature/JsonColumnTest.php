<?php

use Livewire\Livewire;
use ValentinMorice\FilamentJsonColumn\Tests\Support\FormTestComponent;

it('renders', function () {
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

it('throws an exception with invalid editor mode', function () {
    expect(fn () => Livewire::test(FormTestComponent::class, [
        'options' => [
            'editorModes' => ['invalid'],
        ],
    ]))->toThrow(\Exception::class);
});
