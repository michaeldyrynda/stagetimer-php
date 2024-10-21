<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Enums;

enum Trigger: string
{
    case Linked = 'LINKED';

    case Manual = 'MANUAL';

    case Scheduled = 'SCHEDULED';
}
