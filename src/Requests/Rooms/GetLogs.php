<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Rooms;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

final class GetLogs extends Request
{
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
