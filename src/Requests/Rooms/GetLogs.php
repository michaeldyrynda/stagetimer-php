<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Rooms;

use Saloon\Enums\Method;
use Saloon\Http\Request;
use SensitiveParameter;

final class GetLogs extends Request
{
    protected Method $method = Method::GET;

    public function __construct(
        #[SensitiveParameter] private string $roomId,
        private ?int $limit,
        private ?int $offset,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/get_logs';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'room_id' => $this->roomId,
            'limit' => $this->limit,
            'offset' => $this->offset,
        ]);
    }
}
