<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Requests\Timers as Requests;
use Dyrynda\Stagetimer\Resource;

final class Timers extends Resource
{
    public function all(string $roomId): Data\Timers\TimerCollectionData
    {
        return Data\Timers\TimerCollectionData::fromArray(
            $this->connector->send(new Requests\GetAllTimers($roomId))->json()
        );
    }

    public function create(string $roomId, Data\Timers\TimerRequestData $data): Data\Timers\TimerResponseData
    {
        return Data\Timers\TimerResponseData::fromArray(
            $this->connector->send(new Requests\CreateTimer($roomId, $data))->json()
        );
    }

    public function delete(string $roomId, string $timerId): Data\StatusResponseData
    {
        return Data\StatusResponseData::fromArray(
            $this->connector->send(new Requests\DeleteTimer($roomId, $timerId))->json()
        );
    }

    public function get(string $roomId, string $timerId): Data\Timers\TimerResponseData
    {
        return Data\Timers\TimerResponseData::fromArray(
            $this->connector->send(new Requests\GetTimer($roomId, $timerId))->json()
        );
    }

    public function reset(string $roomId, string $timerId): Data\Timers\TimerToggleResponseData
    {
        return Data\Timers\TimerToggleResponseData::fromArray(
            $this->connector->send(new Requests\ResetTimer($roomId, $timerId))->json()
        );
    }

    public function start(string $roomId, string $timerId): Data\Timers\TimerToggleResponseData
    {
        return Data\Timers\TimerToggleResponseData::fromArray(
            $this->connector->send(new Requests\StartTimer($roomId, $timerId))->json()
        );
    }

    public function stop(string $roomId, string $timerId): Data\Timers\TimerToggleResponseData
    {
        return Data\Timers\TimerToggleResponseData::fromArray(
            $this->connector->send(new Requests\StopTimer($roomId, $timerId))->json()
        );
    }

    public function toggle(string $roomId, string $timerId): Data\Timers\TimerToggleResponseData
    {
        return Data\Timers\TimerToggleResponseData::fromArray(
            $this->connector->send(new Requests\ToggleTimer($roomId, $timerId))->json()
        );
    }

    public function update(string $roomId, string $timerId, Data\Timers\TimerRequestData $data): Data\Timers\TimerResponseData
    {
        return Data\Timers\TimerResponseData::fromArray(
            $this->connector->send(new Requests\UpdateTimer($roomId, $timerId, $data))->json()
        );
    }
}
