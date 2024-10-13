<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Carbon\CarbonTimeZone;
use Dyrynda\Stagetimer\Data\Rooms as Data;
use Dyrynda\Stagetimer\Requests\Rooms as Requests;
use Dyrynda\Stagetimer\Stagetimer;
use Saloon\Http\Faking\MockClient;
use Tests\StagetimerFixture;

describe('Room endpoints', function () {
    it('can get the playback status for a room', function () {
        MockClient::global([
            Requests\GetPlaybackStatus::class => new StagetimerFixture('rooms/playback-status'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->rooms()->playbackStatus('theroom'))
            ->toBeInstanceOf(Data\PlaybackStatusData::class)
            ->ok->toBeTrue()
            ->message->toBe('Playback status loaded')
            ->timerId->toBe('theTimerId')
            ->running->toBeFalse()
            ->updatedAt->toEqual(CarbonImmutable::parse('2024-10-13 11:47:14.313000'))
            ->start->toEqual(CarbonImmutable::parse('2024-10-13 06:01:50.506000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-13 06:11:50.506000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-13 06:01:50.506000'))
            ->serverTime->toEqual(CarbonImmutable::parse('2024-10-13 11:47:14.313000'))
            ->duration->toBe('10 minutes');
    });

    it('can get a room', function () {
        MockClient::global([
            Requests\GetRoom::class => new StagetimerFixture('rooms/get-room'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->rooms()->get('theroom'))
            ->toBeInstanceOf(Data\RoomData::class)
            ->ok->toBeTrue()
            ->message->toBe('Room loaded')
            ->id->toBe('theroom')
            ->updatedAt->toEqual(CarbonImmutable::parse('2024-10-13 11:15:24.88600'))
            ->name->toBe('the room name')
            ->blackout->toBeFalse()
            ->focusMessage->toBeFalse()
            ->logo->toBe('https://stagetimer.io/assets/logo-dark.png')
            ->timezone->toEqual(CarbonTimeZone::create('Australia/Adelaide'));
    });

    it('can get room logs', function () {
        MockClient::global([
            Requests\GetLogs::class => new StagetimerFixture('rooms/get-logs'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->rooms()->logs('theroom'))
            ->toBeInstanceOf(Data\LogData::class)
            ->ok->toBeTrue()
            ->message->toBe('Logs loaded')
            ->data->not->toBeEmpty();
    });
});
