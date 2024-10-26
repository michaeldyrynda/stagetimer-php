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

    public function get(string $roomId, string $messageId, ?int $index = null): Data\Messages\MessageResponseData
    {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\GetMessage($roomId, $messageId, $index))->json()
        );
    }

    public function getAll(string $roomId): Data\Messages\MessageCollectionData
    {
        return Data\Messages\MessageCollectionData::fromArray(
            $this->connector->send(new Requests\GetAllMessages($roomId))->json()
        );
    }

    public function hide(string $roomId, string $messageId, ?int $index = null): Data\Messages\MessageResponseData
    {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\HideMessage($roomId, $messageId, $index))->json()
        );
    }

    public function show(string $roomId, string $messageId, ?int $index = null): Data\Messages\MessageResponseData
    {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\ShowMessage($roomId, $messageId, $index))->json()
        );
    }

    public function toggle(string $roomId, string $messageId, ?int $index = null): Data\Messages\MessageResponseData
    {
        return Data\Messages\MessageResponseData::fromArray(
            $this->connector->send(new Requests\ToggleMessage($roomId, $messageId, $index))->json()
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
