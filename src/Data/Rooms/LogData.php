<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Rooms;

use Dyrynda\Stagetimer\Data;

final readonly class LogData extends Data
{
    /**
     * @param  string[]  $data
     */
    public function __construct(
        public bool $ok,
        public string $message,
        public array $data,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            data: $properties['data'],
        );
    }
}
