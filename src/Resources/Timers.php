<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\Timers\TimerRequestData;
use Dyrynda\Stagetimer\Data\Timers\TimerResponseData;
use Dyrynda\Stagetimer\Requests\Timers as Requests;
use Dyrynda\Stagetimer\Resource;

final class Timers extends Resource
{
    public function create(string $roomId, TimerRequestData $data): TimerResponseData
    {
        return TimerResponseData::fromArray(
            $this->connector->send(new Requests\CreateTimer($roomId, $data))->json()
        );
    }

    public function update(string $roomId, string $timerId, TimerRequestData $data): TimerResponseData
    {
        return TimerResponseData::fromArray(
            $this->connector->send(new Requests\UpdateTimer($roomId, $timerId, $data))->json()
        );
    }
}
