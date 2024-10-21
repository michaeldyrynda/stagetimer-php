<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Enums;

enum Type: string
{
    case Duration = 'DURATION';

    case FinishTime = 'FINISH_TIME';
}
