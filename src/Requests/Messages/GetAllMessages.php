<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Messages;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class GetAllMessages extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/get_all_messages';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ];
    }
}
