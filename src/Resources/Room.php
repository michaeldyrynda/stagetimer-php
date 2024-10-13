<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\Rooms\PlaybackStatusData;
use Dyrynda\Stagetimer\Data\Rooms\RoomData;
use Dyrynda\Stagetimer\Requests\Rooms as Requests;
use Dyrynda\Stagetimer\Resource;

class Room extends Resource
{
    public function get(string $roomId): RoomData
    {
        return RoomData::fromArray(
            $this->connector->send(new Requests\GetRoom($roomId))->json()
        );
    }

    public function logs(string $roomId, ?int $limit = null, ?int $offset = null): LogData
    {
        //
    }

    public function playbackStatus(string $roomId): PlaybackStatusData
    {
        return PlaybackStatusData::fromArray(
            $this->connector->send(new Requests\GetPlaybackStatus($roomId))->json()
        );
    }
}
