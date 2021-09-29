<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\MonthlyRecurring;

it('returns array with recurring', function () {
    $eventFrom = new DateTime();
    $eventTo = (new DateTime())->modify('+2 hours');
    $stopRecurring = (new DateTime())->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new MonthlyRecurring($event, $stopRecurring, 1);

    expect($recurring->getDays())->toBeArray();
});

test('it recurring every 2 months expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+6 months');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new MonthlyRecurring($event, $stopRecurring, 2);

    expect($recurring->getDays())->toHaveCount(3);
});

test('it recurring every month expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+8 months');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new MonthlyRecurring($event, $stopRecurring, 1);

    ray($recurring->getDays());

    expect($recurring->getDays())->toHaveCount(7);
});
