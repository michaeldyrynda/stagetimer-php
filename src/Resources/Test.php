<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Resources;

use Dyrynda\Stagetimer\Data\Test as Data;
use Dyrynda\Stagetimer\Requests\Test as Requests;
use Dyrynda\Stagetimer\Resource;

final class Test extends Resource
{
    public function connection(): Data\ConnectionData
    {
        return Data\ConnectionData::fromArray(
            $this->connector->send(new Requests\Connection)->json()
        );
    }
}
