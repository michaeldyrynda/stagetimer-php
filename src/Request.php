<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer;

use Saloon\Enums\Method;
use Saloon\Http\Request as BaseRequest;

abstract class Request extends BaseRequest
{
    protected Method $method = Method::GET;
}
