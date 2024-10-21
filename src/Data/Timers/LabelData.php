<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Dyrynda\Stagetimer\Contracts\Arrayable;
use Dyrynda\Stagetimer\Data;

final readonly class LabelData extends Data implements Arrayable
{
    public function __construct(
        public string $name,
        public string $color,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            name: $properties['name'] ?? '',
            color: $properties['color'] ?? '',
        );
    }

    /**
     * @return array<string, string>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'color' => $this->color,
        ];
    }
}
