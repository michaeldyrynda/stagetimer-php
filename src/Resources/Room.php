<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\Room\PlaybackStatusData;
use Dyrynda\Stagetimer\Requests\Room as Requests;
use Dyrynda\Stagetimer\Resource;

class Room extends Resource
{
    public function playbackStatus(string $roomId): PlaybackStatusData
    {
        return PlaybackStatusData::fromArray(
            $this->connector->send(new Requests\GetPlaybackStatus($roomId))->json()
        );
    }

    public function get(string $roomId)
    {
        //
    }

    public function logs(string $roomId, ?int $limit = null, ?int $offset = null)
    {
        //
    }
}
