<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Messages;

use Dyrynda\Stagetimer\Contracts\Arrayable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Color;

final readonly class MessageRequestData extends Data implements Arrayable
{
    public function __construct(
        public string $text = '',
        public ?Color $color = null,
        public bool $bold = false,
        public bool $uppercase = false,
    ) {}

    public static function fromArray(array $properties = []): static
    {
        return new self(
            text: $properties['text'] ?? '',
            color: Color::tryFrom($properties['color'] ?? ''),
            bold: $properties['bold'] ?? false,
            uppercase: $properties['uppercase'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'color' => $this->color?->value,
            'bold' => $this->bold,
            'uppercase' => $this->uppercase,
        ];
    }
}
