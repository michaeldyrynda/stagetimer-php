<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Room;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use SensitiveParameter;

final class GetPlaybackStatus extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        #[SensitiveParameter] private string $roomId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/get_status';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ];
    }
}
