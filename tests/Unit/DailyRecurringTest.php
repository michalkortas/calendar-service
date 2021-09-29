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

    ray($recurring->getDays());

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
