<?php

declare(strict_types=1);

namespace Tests;

use Saloon\Http\Faking\Fixture;

class StagetimerFixture extends Fixture
{
    protected function defineSensitiveHeaders(): array
    {
        return [
            'Authorization' => 'Bearer: REDACTED',
            '_id' => 'REDACTED',
        ];
    }
}
