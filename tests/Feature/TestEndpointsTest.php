<?php

declare(strict_types=1);

use Dyrynda\Stagetimer\Data\Test\AuthorizationData;
use Dyrynda\Stagetimer\Data\Test\ConnectionData;
use Dyrynda\Stagetimer\Requests\Test\Authorization;
use Dyrynda\Stagetimer\Requests\Test\Connection;
use Dyrynda\Stagetimer\Stagetimer;
use Saloon\Http\Faking\MockClient;
use Tests\StagetimerFixture;

describe('General test endpoints', function () {
    it('can make a test connection', function () {
        $mock = MockClient::global([
            Connection::class => new StagetimerFixture('test/connection'),
        ]);

        $stagetimer = new Stagetimer(
            key: 'thekey',
        );

        expect($stagetimer->test()->connection())
            ->toBeInstanceOf(ConnectionData::class)
            ->ok->toBeTrue()
            ->message->not->toBeEmpty();
    });

    it('can make a test authorization', function () {
        $mock = MockClient::global([
            Authorization::class => new StagetimerFixture('test/authorization'),
        ]);

        $stagetimer = new Stagetimer(
            key: 'thekey',
        );

        expect($stagetimer->test()->authorization(roomId: 'room123'))
            ->toBeInstanceOf(AuthorizationData::class)
            ->ok->toBeTrue()
            ->message->not->toBeEmpty();
    });
});
