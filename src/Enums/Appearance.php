<?php

declare(strict_types=1);

namespace Dyrynda\Stagetimer\Enums;

enum Appearance: string
{
    case CountUp = 'COUNTUP';

    case CountUpTod = 'COUNTUP_TOD';

    case Countdown = 'COUNTDOWN';

    case CountdownTod = 'COUNTDOWN_TOD';

    case Hidden = 'HIDDEN';

    case Tod = 'TOD';
}
