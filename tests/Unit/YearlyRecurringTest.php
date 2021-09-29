<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\YearlyRecurring;

it('returns array with recurring', function () {
    $eventFrom = new DateTime();
    $eventTo = (new DateTime())->modify('+2 hours');
    $stopRecurring = (new DateTime())->modify('+14 days');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new YearlyRecurring($event, $stopRecurring, 1);

    expect($recurring->getDays())->toBeArray();
});

test('it recurring every 2 years expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+5 years');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new YearlyRecurring($event, $stopRecurring, 2);

    expect($recurring->getDays())->toHaveCount(2);
});

test('it recurring every year expect today', function () {
    $eventFrom = new DateTime('wednesday this week');
    $eventTo = (new DateTime('wednesday this week'))->modify('+2 hours');
    $stopRecurring = (new DateTime('wednesday this week'))->modify('+5 years');

    $event = new CalendarEvent(
        $eventFrom->format('Y-m-d H:i'),
        $eventTo->format('Y-m-d H:i')
    );

    $recurring = new YearlyRecurring($event, $stopRecurring, 1);

    ray($recurring->getDays());

    expect($recurring->getDays())->toHaveCount(5);
});
