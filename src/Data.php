<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer;

abstract readonly class Data
{
    /**
     * @param  mixed[]  $properties
     */
    abstract public static function fromArray(array $properties): static;
}
