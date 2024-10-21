<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer;

use Saloon\Http\Connector;
use Saloon\Traits\Auth\AuthenticatesRequests;
use Saloon\Traits\Plugins\AcceptsJson;
use Saloon\Traits\Plugins\AlwaysThrowOnErrors;
use SensitiveParameter;

class Stagetimer extends Connector
{
    use AcceptsJson;
    use AlwaysThrowOnErrors;
    use AuthenticatesRequests;

    public function __construct(
        #[SensitiveParameter] protected readonly string $key,
    ) {
        $this->withTokenAuth($this->key);
    }

    public function resolveBaseUrl(): string
    {
        return 'https://api.stagetimer.io/v1/';
    }

    public function rooms(): Resources\Rooms
    {
        return new Resources\Rooms($this);
    }

    public function test(): Resources\Test
    {
        return new Resources\Test($this);
    }

    public function timers(): Resources\Timers
    {
        return new Resources\Timers($this);
    }
}
