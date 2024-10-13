<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Room;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Dyrynda\Stagetimer\Data;

final readonly class PlaybackStatusData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
        public string $timerId,
        public CarbonImmutable $updatedAt,
        public bool $running,
        public CarbonImmutable $start,
        public CarbonImmutable $finish,
        public ?CarbonImmutable $pause,
        public CarbonImmutable $serverTime,
        public string $duration,
    ) {}

    public static function fromArray(array $properties): static
    {
        $data = $properties['data'];

        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            timerId: $data['timer_id'],
            updatedAt: CarbonImmutable::parse($data['_updated_at']),
            running: $data['running'],
            start: $start = CarbonImmutable::createFromTimestampMsUTC($data['start']),
            finish: $end = CarbonImmutable::createFromTimestampMsUTC($data['finish']),
            pause: $data['running'] === false
                ? CarbonImmutable::createFromTimestampMsUTC($data['pause'])
            : null,
            serverTime: CarbonImmutable::createFromTimestampMsUTC($data['server_time']),
            duration: CarbonInterval::seconds($end->diffInSeconds($start))->cascade()->forHumans(),
        );
    }
}
