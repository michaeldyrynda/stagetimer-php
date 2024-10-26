<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Messages;

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Color;

final readonly class MessageData extends Data
{
    public function __construct(
        public string $id,
        public CarbonImmutable $updatedAt,
        public bool $showing,
        public string $text,
        public Color $color,
        public bool $bold,
        public bool $uppercase,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            id: $properties['_id'],
            updatedAt: CarbonImmutable::parse($properties['_updated_at']),
            showing: $properties['showing'],
            text: $properties['text'],
            color: Color::from($properties['color']),
            bold: $properties['bold'],
            uppercase: $properties['uppercase'],
        );
    }
}
