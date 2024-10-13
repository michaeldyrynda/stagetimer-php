<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Test;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use SensitiveParameter;

class Authorization extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        #[SensitiveParameter] private readonly string $roomId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/test_auth';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ];
    }
}
