<?php

declare(strict_types=1);

use Carbon\Carbon;
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
            ->timerId->toBe('thetimerid')
            ->name->toBe('The test timer')
            ->speaker->toBe('Michael Dyrynda')
            ->notes->toBe('these are the notes for the test timer')
            ->labels->{0}->name->toBe('Timer label')
            ->labels->{0}->color->toBe('#F44336')
            ->appearance->toBe(Appearance::Countdown)
            ->type->toBe(Type::FinishTime)
            ->duration->toBe('1:30:15')
            ->hours->toBe(1)
            ->minutes->toBe(30)
            ->seconds->toBe(15)
            ->wrapUpYellow->toBe(900)
            ->wrapUpRed->toBe(300)
            ->startTime->toEqual(Carbon::parse('2024-11-07T09:15:00Z'))
            ->startTimeUsesDate->toBeTrue()
            ->finishTime->toEqual(Carbon::parse('2024-11-07T10:45:15'))
            ->finishTimeUsesDate->toBeTrue();
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
            ->timerId->toBe('thetimerid')
            ->name->toBe('The updated test timer')
            ->speaker->toBe('Lucas Herrman')
            ->notes->toBe('these notes were updated')
            ->labels->{0}->name->toBe('Updated label')
            ->labels->{0}->color->toBe('#4CAF50')
            ->appearance->toBe(Appearance::CountdownTod)
            ->type->toBe(Type::Duration)
            ->duration->toBe('0:45:30')
            ->hours->toBe(0)
            ->minutes->toBe(45)
            ->seconds->toBe(30)
            ->wrapUpYellow->toBe(600)
            ->wrapUpRed->toBe(300)
            ->startTime->toEqual(Carbon::parse('2024-11-07T10:30:00Z'))
            ->startTimeUsesDate->toBeFalse()
            ->finishTime->toEqual(Carbon::parse('2024-11-07T11:15:30'))
            ->finishTimeUsesDate->toBeFalse();
    });

    it('can get all timers', function () {})->todo();

    it('can get a timer', function () {})->todo();

    it('can start a timer', function () {})->todo();

    it('can stop a timer', function () {})->todo();

    it('can toggle a timer', function () {})->todo();

    it('can reset a timer', function () {})->todo();

    it('can delete a timer', function () {})->todo();
});
