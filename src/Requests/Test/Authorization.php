<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Test;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Authorization extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/test_auth';
    }
}
