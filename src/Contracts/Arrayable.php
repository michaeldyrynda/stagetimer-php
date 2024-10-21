<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Contracts;

interface Arrayable
{
    /**
     * @return array<array-key, mixed>
     */
    public function toArray(): array;
}
