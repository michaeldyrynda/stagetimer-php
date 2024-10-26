<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Data\Messages;

use Dyrynda\Stagetimer\Data;

final readonly class MessageCollectionData extends Data
{
    /**
     * @param  \Dyrynda\Stagetimer\Data\Messages\MessageData[]  $messages
     */
    public function __construct(
        public bool $ok,
        public string $message,
        public array $messages,
    ) {}

    public static function fromArray(array $properties): static
    {
        return new self(
            ok: $properties['ok'],
            message: $properties['message'],
            messages: array_map(MessageData::fromArray(...), $properties['data']),
        );
    }
}
