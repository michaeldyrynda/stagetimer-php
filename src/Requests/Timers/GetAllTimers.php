<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Timers;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class GetAllTimers extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/get_all_timers';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ];
    }
}
