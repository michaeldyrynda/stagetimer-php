<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Dyrynda\Stagetimer\Data;

final readonly class TimerResponseData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
        public TimerData $timer,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            timer: TimerData::fromArray($properties['data']),
        );
    }
}
