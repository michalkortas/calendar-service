<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\WeeklyRecurring;

it('returns array with recurring', function () {
    $eventFrom = new DateTime();
    $eventTo = (new DateTime())->modify('+2 hours');
    $stopRecurring = (new DateTime())->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1);

    expect($recurring->getDays())->toBeArray();
});

test('it recurring one in two weeks', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1);

    ray($recurring->getDays());

    expect($recurring->getDays())->toHaveCount(1);
});

test('it recurring four in two weeks with 2 days of week', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1, ['4', '5']);

    expect($recurring->getDays())->toHaveCount(4);
});

test('it recurring four in two weeks with 2 days of week and days in first week are after start date', function () {
    $eventFrom = new DateTime('next friday');
    $eventTo = (new DateTime('next friday'))->modify('+2 hours');
    $stopRecurring = (new DateTime('next friday'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1, ['4', '5']);

    expect($recurring->getDays())->toHaveCount(4);
});

test('it recurring four in two weeks with 2 days of week and one day in first week are after start date', function () {
    $eventFrom = new DateTime('next thursday');
    $eventTo = (new DateTime('next thursday'))->modify('+2 hours');
    $stopRecurring = (new DateTime('next thursday'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1, ['3', '5']);

    expect($recurring->getDays())->toHaveCount(4);
});

test('it recurring every second week when weekdays passed', function () {
    $eventFrom = new DateTime('next thursday');
    $eventTo = (new DateTime('next thursday'))->modify('+2 hours');
    $stopRecurring = (new DateTime('next thursday'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 2, ['3', '5']);

    expect($recurring->getDays())->toHaveCount(2);
});

test('it recurring every weekday', function () {
    $eventFrom = new DateTime('next thursday');
    $eventTo = (new DateTime('next thursday'))->modify('+2 hours');
    $stopRecurring = (new DateTime('next thursday'))->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new WeeklyRecurring($event, $stopRecurring, 1, [1, 2, 3, 4, 5, 6, 7]);

    expect($recurring->getDays())->toHaveCount(14);
});
