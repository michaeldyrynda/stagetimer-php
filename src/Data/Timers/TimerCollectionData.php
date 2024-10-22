<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Dyrynda\Stagetimer\Data;

final readonly class TimerCollectionData extends Data
{
    /**
     * @param  \Dyrynda\Stagetimer\Data\Timers\TimerData[]  $timers
     */
    public function __construct(
        public bool $ok,
        public string $message,
        public array $timers,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            timers: array_map(TimerData::fromArray(...), $properties['data'])
        );
    }
}
