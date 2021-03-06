<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\DailyRecurring;

it('returns array with recurring', function () {
    $eventFrom = new DateTime();
    $eventTo = (new DateTime())->modify('+2 hours');
    $stopRecurring = (new DateTime())->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1);

    expect($recurring->getDays())->toBeArray();
});

test('it recurring every 2 days expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 2);

    expect($recurring->getDays())->toHaveCount(6);
});

test('it recurring every day expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1);

    expect($recurring->getDays())->toHaveCount(13);
});

test('it return origin of daily event', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1);

    $originArray = [
        $recurring->getOrigin()->from->format('YmdHis'),
        $recurring->getOrigin()->to->format('YmdHis'),
    ];

    $eventArray = [
        $eventFrom->format('YmdHis'),
        $eventTo->format('YmdHis'),
    ];

    expect($originArray)->toEqual($eventArray);
});

test('it recurring only on specified day', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1, [1]);

    expect($recurring->getDays())->toHaveCount(2);
});

test('it recurring only on specified days', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1, [1, 5]);

    expect($recurring->getDays())->toHaveCount(4);
});

test('it return origin of weekly event', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new DailyRecurring($event, $stopRecurring, 1);

    $originArray = [
        $recurring->getOrigin()->from->format('YmdHis'),
        $recurring->getOrigin()->to->format('YmdHis'),
    ];

    $eventArray = [
        $eventFrom->format('YmdHis'),
        $eventTo->format('YmdHis'),
    ];

    expect($originArray)->toEqual($eventArray);
});

