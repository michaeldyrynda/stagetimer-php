<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Messages;

use Dyrynda\Stagetimer\Data;

final readonly class MessageResponseData extends Data
{
    public function __construct(
        public bool $ok,
        public string $message,
        public MessageData $data,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            data: MessageData::fromArray($properties['data']),
        );
    }
}
