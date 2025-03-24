<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace ValentinMorice\FilamentJsonColumn;

use Closure;
use Filament\Forms\Components\Field;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class FilamentJsonColumn extends Field
{
    protected string $view = 'filament-json-column::index';

    protected string $errorMessage = '';

    protected bool | Closure $editorMode = false;

    protected bool | Closure $viewerMode = false;

    protected string | Closure $accent = 'slateblue';

    protected int | Closure $editorHeight = 300;

    protected int | Closure $viewerHeight = 308;

    protected array | Closure  $modes = ['code', 'form', 'text', 'tree', 'view', 'preview' ];

    protected function setUp(): void
    {
        parent::setUp();

        $this->beforeStateDehydrated(function(FilamentJsonColumn $component, $state) {
            if (is_string($state)) {
                $decodedState = json_decode($state, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    Notification::make()
                        ->title($component->getErrorMessage() === '' ? 'Fix the invalid JSON values' : $component->getErrorMessage())
                        ->danger()
                        ->send();

                    throw ValidationException::withMessages([]);
                }

                $component->state($decodedState);
            }
        });
    }

    public function getEditorHeight(): string
    {
        return $this->evaluate($this->editorHeight).'px';
    }

    public function getViewerHeight(): string
    {
        return $this->evaluate($this->viewerHeight).'px';
    }

    public function getAccent(): string
    {
        return $this->evaluate($this->accent);
    }

    public function getEditorMode(): bool
    {
        return $this->evaluate($this->editorMode);
    }

    public function getViewerMode(): bool
    {
        return $this->evaluate($this->viewerMode);
    }

    public function getModes(): array
    {
        return $this->evaluate($this->modes);
    }

    public function getErrorMessage(): string
    {
        return $this->evaluate($this->errorMessage);
    }

    public function errorMessage(Closure|string $message): static
    {
        $this->errorMessage = $message;

        return $this;
    }

    public function editorOnly(Closure|bool $bool = true): static
    {
        $this->editorMode = $bool;

        return $this;
    }

    public function viewerOnly(Closure|bool $bool = true): static
    {
        $this->viewerMode = $bool;

        return $this;
    }

    public function editorHeight(Closure|int $heightInPx): static
    {
        $this->editorHeight = $heightInPx;

        return $this;
    }

    public function viewerHeight(Closure|int $heightInPx): static
    {
        $this->viewerHeight = $heightInPx;

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function editorModes(Closure|array $modes): static
    {
        foreach ((array) $modes as $mode) {
            if (!in_array($mode, $this->modes, true)) {
                throw new \Exception("Invalid parameter: " . json_encode($modes) . ". Allowed values are: " . implode(', ', $this->modes));
            }
        }

        $this->modes = $modes;

        return $this;
    }

    public function accent(Closure|string $hexcode): static
    {
        $this->accent = $hexcode;

        return $this;
    }
}
