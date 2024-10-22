<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Timers;

use Dyrynda\Stagetimer\Data\Timers\TimerRequestData;
use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class UpdateTimer extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        #[SensitiveParameter] private string $timerId,
        private TimerRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/update_timer';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
            'timer_id' => $this->timerId,
        ] + $this->data->toArray();
    }
}
