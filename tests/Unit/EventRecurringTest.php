<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\WeeklyRecurring;
use michalkortas\CalendarService\Facades\EventRecurring;

$eventFrom = new DateTime();
$eventTo = (new DateTime())->modify('+2 hours');
$stopRecurring = (new DateTime())->modify('+14 days');

it('returns daily recurring', function () use ($eventFrom, $eventTo, $stopRecurring) {

    $recurring = EventRecurring::getDailyRecurring($eventFrom, $eventTo, $stopRecurring, 1);

    expect(method_exists($recurring, 'getDays'))->toBeTrue();
});

it('returns weekly recurring', function () use ($eventFrom, $eventTo, $stopRecurring) {

    $recurring = EventRecurring::getWeeklyRecurring($eventFrom, $eventTo, $stopRecurring, 1);

    expect(method_exists($recurring, 'getDays'))->toBeTrue();
});

it('returns monthly recurring', function () use ($eventFrom, $eventTo, $stopRecurring) {

    $recurring = EventRecurring::getMonthlyRecurring($eventFrom, $eventTo, $stopRecurring, 1);

    expect(method_exists($recurring, 'getDays'))->toBeTrue();
});

it('returns yearly recurring', function () use ($eventFrom, $eventTo, $stopRecurring) {

    $recurring = EventRecurring::getYearlyRecurring($eventFrom, $eventTo, $stopRecurring, 1);

    expect(method_exists($recurring, 'getDays'))->toBeTrue();
});
