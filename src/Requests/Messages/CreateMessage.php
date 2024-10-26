<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Messages;

use Dyrynda\Stagetimer\Data\Messages\MessageRequestData;
use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class CreateMessage extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        private MessageRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/create_message';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
        ] + $this->data->toArray();
    }
}
