<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums\Appearance;
use Dyrynda\Stagetimer\Enums\Trigger;
use Dyrynda\Stagetimer\Enums\Type;
use Dyrynda\Stagetimer\Requests\Timers as Requests;
use Dyrynda\Stagetimer\Stagetimer;
use Saloon\Http\Faking\MockClient;
use Tests\StagetimerFixture;

describe('Timer endpoints', function () {
    it('can create a timer', function () {
        MockClient::global([
            Requests\CreateTimer::class => new StagetimerFixture('timers/create-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        $data = new Data\Timers\TimerRequestData(
            name: 'The test timer',
            speaker: 'Michael Dyrynda',
            notes: 'these are the notes for the test timer',
            labels: [
                new Data\Timers\LabelData(name: 'Timer label', color: '#F44336'),
            ],
            appearance: Appearance::Countdown,
            type: Type::FinishTime,
            hours: 1,
            minutes: 30,
            seconds: 15,
            wrapUpYellow: 60 * 15,
            wrapUpRed: 60 * 5,
            trigger: Trigger::Scheduled,
            startTime: CarbonImmutable::parse('2024-11-07 09:15:00'),
            startTimeUsesDate: true,
            finishTime: CarbonImmutable::parse('2024-11-07 10:45:15'),
            finishTimeUsesDate: true,
        );

        expect($stagetimer->timers()->create(roomId: 'theroom', data: $data))
            ->toBeInstanceOf(Data\Timers\TimerResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer created')
            ->timer->toBeInstanceOf(Data\Timers\TimerData::class)
            ->timer->id->toBe('thetimerid')
            ->timer->name->toBe('The test timer')
            ->timer->speaker->toBe('Michael Dyrynda')
            ->timer->notes->toBe('these are the notes for the test timer')
            ->timer->labels->{0}->name->toBe('Timer label')
            ->timer->labels->{0}->color->toBe('#F44336')
            ->timer->appearance->toBe(Appearance::Countdown)
            ->timer->type->toBe(Type::FinishTime)
            ->timer->duration->toBe('1:30:15')
            ->timer->hours->toBe(1)
            ->timer->minutes->toBe(30)
            ->timer->seconds->toBe(15)
            ->timer->wrapUpYellow->toBe(900)
            ->timer->wrapUpRed->toBe(300)
            ->timer->startTime->toEqual(CarbonImmutable::parse('2024-11-07T09:15:00Z'))
            ->timer->startTimeUsesDate->toBeTrue()
            ->timer->finishTime->toEqual(CarbonImmutable::parse('2024-11-07T10:45:15'))
            ->timer->finishTimeUsesDate->toBeTrue();
    });

    it('can update a timer', function () {
        MockClient::global([
            Requests\UpdateTimer::class => new StagetimerFixture('timers/update-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        $data = new Data\Timers\TimerRequestData(
            name: 'The updated test timer',
            speaker: 'Lucas Herrman',
            notes: 'these notes were updated',
            labels: [
                new Data\Timers\LabelData(name: 'Updated label', color: '#4CAF50'),
            ],
            appearance: Appearance::CountdownTod,
            type: Type::Duration,
            hours: 0,
            minutes: 45,
            seconds: 30,
            wrapUpYellow: 60 * 10,
            wrapUpRed: 60 * 5,
            trigger: Trigger::Manual,
            startTime: CarbonImmutable::parse('2024-11-07 10:30:00'),
            startTimeUsesDate: false,
            finishTime: CarbonImmutable::parse('2024-11-07 11:15:30'),
            finishTimeUsesDate: false,
        );

        expect($stagetimer->timers()->update(roomId: 'theroomid', timerId: 'thetimerid', data: $data))
            ->toBeInstanceOf(Data\Timers\TimerResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer updated')
            ->timer->toBeInstanceOf(Data\Timers\TimerData::class)
            ->timer->id->toBe('thetimerid')
            ->timer->name->toBe('The updated test timer')
            ->timer->speaker->toBe('Lucas Herrman')
            ->timer->notes->toBe('these notes were updated')
            ->timer->labels->{0}->name->toBe('Updated label')
            ->timer->labels->{0}->color->toBe('#4CAF50')
            ->timer->appearance->toBe(Appearance::CountdownTod)
            ->timer->type->toBe(Type::Duration)
            ->timer->duration->toBe('0:45:30')
            ->timer->hours->toBe(0)
            ->timer->minutes->toBe(45)
            ->timer->seconds->toBe(30)
            ->timer->wrapUpYellow->toBe(600)
            ->timer->wrapUpRed->toBe(300)
            ->timer->startTime->toEqual(CarbonImmutable::parse('2024-11-07T10:30:00Z'))
            ->timer->startTimeUsesDate->toBeFalse()
            ->timer->finishTime->toEqual(CarbonImmutable::parse('2024-11-07T11:15:30'))
            ->timer->finishTimeUsesDate->toBeFalse();
    });

    it('can get all timers', function () {
        CarbonImmutable::setTestNow('2024-10-22 23:00:01');

        MockClient::global([
            Requests\GetAllTimers::class => new StagetimerFixture('timers/all-timers'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->all(roomId: 'theroomid'))
            ->toBeInstanceOf(Data\Timers\TimerCollectionData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timers loaded')
            ->timers->toContainOnlyInstancesOf(Data\Timers\TimerData::class)
            ->timers->toHaveCount(6)
            ->toMatchSnapshot();
    });

    it('can get a timer', function () {
        MockClient::global([
            Requests\GetTimer::class => new StagetimerFixture('timers/get-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->get(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\Timers\TimerResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer loaded')
            ->timer->id->toBe('thetimerid')
            ->timer->name->toBe('The updated test timer');
    });

    it('can start a timer', function () {
        MockClient::global([
            Requests\StartTimer::class => new StagetimerFixture('timers/start-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'key');

        expect($stagetimer->timers()->start(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\Timers\TimerToggleResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer started at `0:45:30`')
            ->timerId->toBe('thetimerid')
            ->running->toBeTrue()
            ->start->toEqual(CarbonImmutable::parse('2024-10-25T11:33:50.234000+0000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-25T12:19:20.234000+0000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-25T11:33:50.234000+0000'));
    });

    it('can stop a timer', function () {
        MockClient::global([
            Requests\StopTimer::class => new StagetimerFixture('timers/stop-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->stop(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\Timers\TimerToggleResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer stopped at `0:34:03`')
            ->timerId->toBe('thetimerid')
            ->running->toBeFalse()
            ->start->toEqual(CarbonImmutable::parse('2024-10-25T11:33:50.234000+0000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-25T12:19:20.234000+0000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-25T11:45:17.877000+0000'));
    });

    it('can toggle a timer', function () {
        MockClient::global([
            Requests\ToggleTimer::class => new StagetimerFixture('timers/toggle-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->toggle(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\Timers\TimerToggleResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer started at `0:34:03`')
            ->timerId->toBe('thetimerid')
            ->running->toBeTrue()
            ->start->toEqual(CarbonImmutable::parse('2024-10-25T11:38:17.665000+0000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-25T12:23:47.665000+0000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-25T11:45:17.877000+0000'));
    });

    it('can reset a timer', function () {
        MockClient::global([
            Requests\ResetTimer::class => new StagetimerFixture('timers/reset-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->reset(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\Timers\TimerToggleResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer reset to `0:45:30`')
            ->timerId->toBe('thetimerid')
            ->running->toBeFalse()
            ->start->toEqual(CarbonImmutable::parse('2024-10-25T11:53:02.185000+0000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-25T12:38:32.185000+0000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-25T11:53:02.185000+0000'));
    });

    it('can delete a timer', function () {
        MockClient::global([
            Requests\DeleteTimer::class => new StagetimerFixture('timers/delete-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'f59b426077cba8082c6111cb46207aae');

        expect($stagetimer->timers()->delete(roomId: 'R4XW612F', timerId: '671634ba3f59e95f03137ef9'))
            ->toBeInstanceOf(Data\StatusResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer deleted');
    });
});
