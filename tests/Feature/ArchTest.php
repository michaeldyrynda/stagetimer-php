<?php

use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Resource;
use Saloon\Http\Request;

arch()
    ->expect('Dyrynda\Stagetimer')
    ->toUseStrictTypes();

arch()
    ->expect('Dyrynda\Stagetimer\Requests')
    ->toExtend(Request::class);

arch()
    ->expect('Dyrynda\Stagetimer\Resources')
    ->not->toHaveSuffix('Request')
    ->toExtend(Resource::class);

arch()
    ->expect('Dyrynda\Stagetimer\Data')
    ->toBeFinal()
    ->toBeReadonly()
    ->toHaveSuffix('Data')
    ->toExtend(Data::class);

arch()->preset()->php();
