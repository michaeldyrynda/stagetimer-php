<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data\Timers as Data;
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

        $data = new Data\TimerRequestData(
            name: 'The test timer',
            speaker: 'Michael Dyrynda',
            notes: 'these are the notes for the test timer',
            labels: [
                new Data\LabelData(name: 'Timer label', color: '#F44336'),
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
            ->toBeInstanceOf(Data\TimerResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer created')
            ->timer->toBeInstanceOf(Data\TimerData::class)
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

        $data = new Data\TimerRequestData(
            name: 'The updated test timer',
            speaker: 'Lucas Herrman',
            notes: 'these notes were updated',
            labels: [
                new Data\LabelData(name: 'Updated label', color: '#4CAF50'),
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
            ->toBeInstanceOf(Data\TimerResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer updated')
            ->timer->toBeInstanceOf(Data\TimerData::class)
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
            ->toBeInstanceOf(Data\TimerCollectionData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timers loaded')
            ->timers->toContainOnlyInstancesOf(Data\TimerData::class)
            ->timers->toHaveCount(6)
            ->toMatchSnapshot();
    });

    it('can get a timer', function () {
        MockClient::global([
            Requests\GetTimer::class => new StagetimerFixture('timers/get-timer'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->timers()->get(roomId: 'theroomid', timerId: 'thetimerid'))
            ->toBeInstanceOf(Data\TimerResponseData::class)
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
            ->toBeInstanceOf(Data\TimerToggleResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Timer started at `0:45:30`')
            ->timerId->toBe('thetimerid')
            ->running->toBeTrue()
            ->start->toEqual(CarbonImmutable::parse('2024-10-25T11:33:50.234000+0000'))
            ->finish->toEqual(CarbonImmutable::parse('2024-10-25T12:19:20.234000+0000'))
            ->pause->toEqual(CarbonImmutable::parse('2024-10-25T11:33:50.234000+0000'));
    });

    it('can stop a timer', function () {})->todo();

    it('can toggle a timer', function () {})->todo();

    it('can reset a timer', function () {})->todo();

    it('can delete a timer', function () {})->todo();
});
