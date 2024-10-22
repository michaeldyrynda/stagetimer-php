<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Appearance;
use Dyrynda\Stagetimer\Enums\Type;

final readonly class TimerData extends Data
{
    /**
     * @param  \Dyrynda\Stagetimer\Data\Timers\LabelData[]  $labels
     */
    public function __construct(
        public string $id,
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
        return new self(
            id: $properties['_id'],
            name: $properties['name'],
            speaker: $properties['speaker'],
            notes: $properties['notes'],
            labels: array_map(LabelData::fromArray(...), $properties['labels']),
            appearance: Appearance::tryFrom($properties['appearance'] ?? ''),
            type: Type::tryFrom($properties['type'] ?? ''),
            duration: $properties['duration'],
            hours: $properties['hours'],
            minutes: $properties['minutes'],
            seconds: $properties['seconds'],
            wrapUpYellow: $properties['wrap_up_yellow'],
            wrapUpRed: $properties['wrap_up_red'] ?? '',
            startTime: CarbonImmutable::parse($properties['start_time']),
            startTimeUsesDate: $properties['start_time_uses_date'],
            finishTime: CarbonImmutable::parse($properties['finish_time']),
            finishTimeUsesDate: $properties['finish_time_uses_date'],
        );
    }
}
