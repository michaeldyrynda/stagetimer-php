<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Timers;

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Contracts\Arrayable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Appearance;
use Dyrynda\Stagetimer\Enums\Trigger;
use Dyrynda\Stagetimer\Enums\Type;

final readonly class TimerRequestData extends Data implements Arrayable
{
    /**
     * @param  \Dyrynda\Stagetimer\Data\Timers\LabelData[]  $labels
     */
    public function __construct(
        public ?string $name = null,
        public ?string $speaker = null,
        public ?string $notes = null,
        public array $labels = [],
        public ?Appearance $appearance = null,
        public ?Type $type = null,
        public ?int $hours = null,
        public ?int $minutes = null,
        public ?int $seconds = null,
        public ?int $wrapUpYellow = null,
        public ?int $wrapUpRed = null,
        public ?Trigger $trigger = null,
        public ?CarbonImmutable $startTime = null,
        public bool $startTimeUsesDate = false,
        public ?CarbonImmutable $finishTime = null,
        public bool $finishTimeUsesDate = false,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            name: $properties['name'] ?? '',
            speaker: $properties['speaker'] ?? '',
            notes: $properties['notes'] ?? '',
            labels: $properties['labels'] ?? '',
            appearance: Appearance::tryFrom($properties['appearance'] ?? '') ?: null,
            type: Type::tryFrom($properties['type'] ?? '') ?: null,
            hours: $properties['hours'] ?? '',
            minutes: $properties['minutes'] ?? '',
            seconds: $properties['seconds'] ?? '',
            wrapUpYellow: $properties['wrapUpYellow'] ?? '',
            wrapUpRed: $properties['wrapUpRed'] ?? '',
            trigger: Trigger::tryFrom($properties['trigger'] ?? '') ?: null,
            startTime: $properties['startTime'] ?? '' ? CarbonImmutable::parse($properties['startTime']) : null,
            startTimeUsesDate: $properties['startTimeUsesDate'] ?? '',
            finishTime: $properties['finishTime'] ?? '' ? CarbonImmutable::parse($properties['finishTime']) : null,
            finishTimeUsesDate: $properties['finishTimeUsesDate'] ?? '',
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'speaker' => $this->speaker,
            'notes' => $this->notes,
            'labels' => array_map(fn (LabelData $data) => $data->toArray(), $this->labels),
            'appearance' => $this->appearance?->value,
            'type' => $this->type?->value,
            'hours' => $this->hours,
            'minutes' => $this->minutes,
            'seconds' => $this->seconds,
            'wrap_up_yellow' => $this->wrapUpYellow,
            'wrap_up_red' => $this->wrapUpRed,
            'trigger' => $this->trigger?->value,
            'start_time' => $this->startTime?->toIso8601ZuluString(),
            'start_time_uses_date' => $this->startTimeUsesDate,
            'finish_time' => $this->finishTime?->toIso8601ZuluString(),
            'finish_time_uses_date' => $this->finishTimeUsesDate,
        ];
    }
}
