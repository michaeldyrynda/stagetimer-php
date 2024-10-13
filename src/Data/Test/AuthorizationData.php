<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Test;

use Dyrynda\Stagetimer\Data;

final readonly class AuthorizationData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(...$properties);
    }
}
