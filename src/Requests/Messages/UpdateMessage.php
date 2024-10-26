<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Messages;

use Dyrynda\Stagetimer\Data\Messages\MessageRequestData;
use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class UpdateMessage extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        #[SensitiveParameter] private string $messageId,
        private MessageRequestData $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/update_message';
    }

    protected function defaultQuery(): array
    {
        return [
            'room_id' => $this->roomId,
            'message_id' => $this->messageId,
        ] + $this->data->toArray();
    }
}
