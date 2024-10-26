<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Requests\Messages;

use Dyrynda\Stagetimer\Request;
use SensitiveParameter;

class ShowMessage extends Request
{
    public function __construct(
        #[SensitiveParameter] private string $roomId,
        #[SensitiveParameter] private string $messageId,
        private ?int $index = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/show_message';
    }

    protected function defaultQuery(): array
    {
        return array_filter([
            'room_id' => $this->roomId,
            'message_id' => $this->messageId,
            'index' => $this->index,
        ]);
    }
}
