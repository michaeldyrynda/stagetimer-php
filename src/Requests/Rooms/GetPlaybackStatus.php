<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Rooms;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

final class GetPlaybackStatus extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/get_status';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ];
    }
}
