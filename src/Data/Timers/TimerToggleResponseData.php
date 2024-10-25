<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;

final readonly class TimerToggleResponseData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
        public string $timerId,
        public bool $running,
        public CarbonImmutable $start,
        public CarbonImmutable $finish,
        public CarbonImmutable $pause,
        public CarbonImmutable $serverTime,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            timerId: $properties['data']['timer_id'],
            running: $properties['data']['running'],
            start: CarbonImmutable::createFromTimestampMsUtc($properties['data']['start']),
            finish: CarbonImmutable::createFromTimestampMsUtc($properties['data']['finish']),
            pause: CarbonImmutable::createFromTimestampMsUtc($properties['data']['pause']),
            serverTime: CarbonImmutable::createFromTimestampMsUtc($properties['data']['server_time']),
        );
    }
}
