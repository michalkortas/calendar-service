<?php

use michalkortas\CalendarService\Services\CalendarService;

it('returns 0 days before monday in week', function () {
    $day = new DateTime('monday this week');
    expect(CalendarService::getEmptyBeginDays($day))->toBe(0);
});

it('returns 2 days before wednesday in week', function () {
    $day = new DateTime('wednesday this week');
    expect(CalendarService::getEmptyBeginDays($day))->toBe(2);
});

it('returns 6 days before sunday in week', function () {
    $day = new DateTime('sunday this week');
    expect(CalendarService::getEmptyBeginDays($day))->toBe(6);
});

it('returns 6 days after monday in week', function () {
    $day = new DateTime('monday this week');
    expect(CalendarService::getEmptyEndDays($day))->toBe(6);
});

it('returns 4 days after wednesday in week', function () {
    $day = new DateTime('wednesday this week');
    expect(CalendarService::getEmptyEndDays($day))->toBe(4);
});

it('returns 0 days after sunday in week', function () {
    $day = new DateTime('sunday this week');
    expect(CalendarService::getEmptyEndDays($day))->toBe(0);
});

it('throws Exception when date doesnt exists', function() {
    CalendarService::getValidDate('2021-12-32');
})->throws(\Exception::class);

it('returns DateTime object when date is valid', function() {
    expect(CalendarService::getValidDate('2021-12-31')->format('Y-m-d'))->toBe((new DateTime('2021-12-31'))->format('Y-m-d'));
});

it('returns array with date Y-m-j as key', function() {
    $calendar = CalendarService::prepareCalendar('2021-12-1', '2021-12-5');
    expect(array_key_exists('2021-12-1', $calendar))->toBe(true);
});

it('throws Exception when one of date doesnt exists', function() {
    CalendarService::prepareCalendar('2021-12-30', '2021-12-35');
})->throws(\Exception::class);

it('returns day names array', function() {
    expect(CalendarService::$dayNames)->toHaveKeys([0, 1, 2, 3, 4, 5, 6]);
});

it('returns month names array', function() {
    expect(CalendarService::$monthNames)->toHaveKeys([1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12]);
});
