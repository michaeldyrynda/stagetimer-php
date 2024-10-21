<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Appearance;
use Dyrynda\Stagetimer\Enums\Type;

final readonly class TimerResponseData extends Data
{
    /**
     * @param  \Dyrynda\Stagetimer\Data\Timers\LabelData[]  $labels
     */
    public function __construct(
        public string $timerId,
        public bool $ok,
        public string $message,
        public string $name,
        public string $speaker,
        public string $notes,
        public array $labels,
        public Appearance $appearance,
        public Type $type,
        public string $duration,
        public int $hours,
        public int $minutes,
        public int $seconds,
        public int $wrapUpYellow,
        public int $wrapUpRed,
        public CarbonImmutable $startTime,
        public bool $startTimeUsesDate,
        public CarbonImmutable $finishTime,
        public bool $finishTimeUsesDate,
    ) {}

    public static function fromArray(array $properties): static
    {
        $data = $properties['data'];

        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            timerId: $data['_id'],
            name: $data['name'],
            speaker: $data['speaker'],
            notes: $data['notes'],
            labels: array_map(LabelData::fromArray(...), $data['labels']),
            appearance: Appearance::tryFrom($data['appearance'] ?? ''),
            type: Type::tryFrom($data['type'] ?? ''),
            duration: $data['duration'],
            hours: $data['hours'],
            minutes: $data['minutes'],
            seconds: $data['seconds'],
            wrapUpYellow: $data['wrap_up_yellow'],
            wrapUpRed: $data['wrap_up_red'] ?? '',
            startTime: CarbonImmutable::parse($data['start_time']),
            startTimeUsesDate: $data['start_time_uses_date'],
            finishTime: CarbonImmutable::parse($data['finish_time']),
            finishTimeUsesDate: $data['finish_time_uses_date'],
        );
    }
}
