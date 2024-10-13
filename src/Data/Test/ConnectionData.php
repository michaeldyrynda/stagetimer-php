<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Test;

use Dyrynda\Stagetimer\Data;

final readonly class ConnectionData extends Data
{
    /**
     * @param  array{docs: string, routes: string[]}  $data
     */
    public function __construct(
        public bool $ok,
        public string $message,
        public array $data,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(...$properties);
    }
}
