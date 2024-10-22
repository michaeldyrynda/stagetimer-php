<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\Timers as Data;
use Dyrynda\Stagetimer\Requests\Timers as Requests;
use Dyrynda\Stagetimer\Resource;

final class Timers extends Resource
{
    public function create(string $roomId, Data\TimerRequestData $data): Data\TimerResponseData
    {
        return Data\TimerResponseData::fromArray(
            $this->connector->send(new Requests\CreateTimer($roomId, $data))->json()
        );
    }

    {
    public function update(string $roomId, string $timerId, Data\TimerRequestData $data): Data\TimerResponseData
    {
        return Data\TimerResponseData::fromArray(
            $this->connector->send(new Requests\UpdateTimer($roomId, $timerId, $data))->json()
        );
    }
}
