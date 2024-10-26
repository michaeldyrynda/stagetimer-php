<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Requests\Messages as Requests;
use Dyrynda\Stagetimer\Resource;

class Messages extends Resource
{
    public function create(string $roomId, Data\Messages\MessageRequestData $data): Data\Messages\MessageResponseData
    {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\CreateMessage($roomId, $data))->json()
        );
    }

    public function update(
        string $roomId,
        string $messageId,
        Data\Messages\MessageRequestData $data,
    ): Data\Messages\MessageResponseData {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\UpdateMessage($roomId, $messageId, $data))->json()
        );
    }
}
