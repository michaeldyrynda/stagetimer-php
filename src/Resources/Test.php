<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\StatusResponseData;
use Dyrynda\Stagetimer\Data\Test\AuthorizationData;
use Dyrynda\Stagetimer\Requests\Test as Requests;
use Dyrynda\Stagetimer\Resource;

final class Test extends Resource
{
    public function connection(): StatusResponseData
    {
        return StatusResponseData::fromArray(
            $this->connector->send(new Requests\Connection)->json()
        );
    }

    public function authorization(string $roomId): AuthorizationData
    {
        return AuthorizationData::fromArray(
            $this->connector->send(new Requests\Authorization($roomId))->json()
        );
    }
}
