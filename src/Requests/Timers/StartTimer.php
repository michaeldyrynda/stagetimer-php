<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Timers;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class StartTimer extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        #[SensitiveParameter] private string $timerId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/start_timer';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
            'timer_id' => $this->timerId,
        ];
    }
}
