<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data\Room\PlaybackStatusData;
use Dyrynda\Stagetimer\Requests\Room\GetPlaybackStatus;
use Dyrynda\Stagetimer\Stagetimer;
use Saloon\Http\Faking\MockClient;
use Tests\StagetimerFixture;

describe('Room endpoints', function () {
    it('can get the playback status for a room', function () {
        MockClient::global([
            GetPlaybackStatus::class => new StagetimerFixture('rooms/playback-status'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->rooms()->playbackStatus('theroom'))
            ->toBeInstanceOf(PlaybackStatusData::class)
            ->ok->toBeTrue()
            ->message->toBe('Playback status loaded')
            ->timerId->toBe('theTimerId')
            ->running->toBeFalse()
            ->start->toEqual(CarbonImmutable::parse('2024-10-13 06:01:50.506000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-13 06:11:50.506000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-13 06:01:50.506000'))
            ->serverTime->toEqual(CarbonImmutable::parse('2024-10-13 11:47:14.313000'))
            ->duration->toBe('10 minutes');
    });
});
