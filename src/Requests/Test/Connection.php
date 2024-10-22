<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Test;

use Dyrynda\Stagetimer\Request;

class Connection extends Request
{
    public function resolveEndpoint(): string
    {
        return '';
    }
}
