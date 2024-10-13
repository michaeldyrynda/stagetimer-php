<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Rooms;

use Carbon\CarbonImmutable;
use Carbon\CarbonTimeZone;
use Dyrynda\Stagetimer\Data;

final readonly class RoomData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
        public string $id,
        public CarbonImmutable $updatedAt,
        public string $name,
        public bool $blackout,
        public bool $focusMessage,
        public string $logo,
        public CarbonTimeZone $timezone,
    ) {}

    public static function fromArray(array $properties): static
    {
        $data = $properties['data'];

        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            id: $data['_id'],
            updatedAt: CarbonImmutable::parse($data['_updated_at']),
            name: $data['name'],
            blackout: $data['blackout'],
            focusMessage: $data['focus_message'],
            logo: $data['logo'],
            timezone: CarbonTimeZone::create($data['timezone']),
        );
    }
}
