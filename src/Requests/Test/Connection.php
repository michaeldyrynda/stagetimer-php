<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Test;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class Connection extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '';
    }
}
