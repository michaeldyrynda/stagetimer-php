<?php

declare(strict_types=1);

use Carbon\CarbonImmutable;
use Dyrynda\Stagetimer\Data;
use Dyrynda\Stagetimer\Enums;
use Dyrynda\Stagetimer\Requests\Messages as Requests;
use Dyrynda\Stagetimer\Stagetimer;
use Saloon\Http\Faking\MockClient;
use Tests\StagetimerFixture;

describe('Message endpoints', function () {
    it('can create a message', function () {
        MockClient::global([
            Requests\CreateMessage::class => new StagetimerFixture('messages/create-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        $data = new Data\Messages\MessageRequestData(
            text: 'This is a message',
            color: Enums\Color::Green,
            bold: true,
            uppercase: true,
        );

        expect($stagetimer->messages()->create(roomId: 'theroomid', data: $data))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message created')
            ->data->id->toBe('themessageid')
            ->data->updatedAt->toEqual(CarbonImmutable::parse('2024-10-26T04:46:01.646000+0000'))
            ->data->showing->toBeFalse()
            ->data->text->toBe('This is a message')
            ->data->color->toBe(Enums\Color::Green)
            ->data->bold->toBeTrue()
            ->data->uppercase->toBeTrue();
    });

    it('can update a message', function () {
        MockClient::global([
            Requests\UpdateMessage::class => new StagetimerFixture('messages/update-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        $data = new Data\Messages\MessageRequestData(
            text: 'The message was updated',
            color: Enums\Color::White,
            bold: false,
            uppercase: false,
        );

        expect($stagetimer->messages()->update(roomId: 'theroomid', messageId: 'themssageid', data: $data))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message updated')
            ->data->id->toBe('themessageid')
            ->data->updatedAt->toEqual(CarbonImmutable::parse('2024-10-26T05:07:01.951000+0000'))
            ->data->showing->toBeFalse()
            ->data->text->toBe('The message was updated')
            ->data->color->toBe(Enums\Color::White)
            ->data->bold->toBeFalse()
            ->data->uppercase->toBeFalse();
    });

    it('can show a message', function () {
        MockClient::global([
            Requests\ShowMessage::class => new StagetimerFixture('messages/show-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->show(roomId: 'theroomid', messageId: 'themessageid'))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message showing')
            ->data->id->toBe('themessageid')
            ->data->updatedAt->toEqual(CarbonImmutable::parse('2024-10-26T05:07:01.951000+0000'))
            ->data->showing->toBeTrue();
    });

    it('can hide a message', function () {
        MockClient::global([
            Requests\HideMessage::class => new StagetimerFixture('messages/hide-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->hide(roomId: 'theroomid', messageId: 'themessageid'))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message hidden')
            ->data->id->toBe('themessageid')
            ->data->updatedAt->toEqual(CarbonImmutable::parse('2024-10-26T05:07:01.951000+0000'))
            ->data->showing->toBeFalse();
    });

    it('can toggle a message', function () {
        MockClient::global([
            Requests\ToggleMessage::class => new StagetimerFixture('messages/toggle-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->toggle(roomId: 'theroomid', messageId: 'themessageid'))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message showing')
            ->data->id->toBe('themessageid')
            ->data->updatedAt->toEqual(CarbonImmutable::parse('2024-10-26T05:07:01.951000+0000'))
            ->data->showing->toBeTrue();
    });

    it('can get all message', function () {
        MockClient::global([
            Requests\GetAllMessages::class => new StagetimerFixture('messages/all-messages'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->getAll(roomId: 'theroomid'))
            ->toBeInstanceOf(Data\Messages\MessageCollectionData::class)
            ->ok->toBeTrue()
            ->message->toBe('Messages loaded')
            ->messages->toContainOnlyInstancesOf(Data\Messages\MessageData::class)
            ->messages->toHaveCount(3)
            ->toMatchSnapshot();
    });

    it('can get a message', function () {
        MockClient::global([
            Requests\GetMessage::class => new StagetimerFixture('messages/get-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->get(roomId: 'theroomid', messageId: 'themessageid'))
            ->toBeInstanceOf(Data\Messages\MessageResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message loaded')
            ->data->id->toBe('themessageid');
    });

    it('can delete a message', function () {
        MockClient::global([
            Requests\DeleteMessage::class => new StagetimerFixture('messages/delete-message'),
        ]);

        $stagetimer = new Stagetimer(key: 'thekey');

        expect($stagetimer->messages()->delete(roomId: 'theroomid', messageId: 'themessageid'))
            ->toBeInstanceOf(Data\StatusResponseData::class)
            ->ok->toBeTrue()
            ->message->toBe('Message deleted');
    });
});
