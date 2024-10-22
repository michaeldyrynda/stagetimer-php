<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Timers;

use Dyrynda\Stagetimer\Data\Timers\TimerRequestData;
use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class CreateTimer extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        private TimerRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/create_timer';
    }

    protected function defaultQuery(): array
    {
        return array_merge([
            'room_id' => $this->roomId,
        ], $this->data->toArray());
    }
}
