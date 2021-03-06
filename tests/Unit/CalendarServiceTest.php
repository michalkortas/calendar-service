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

it('returns empty begin days with work days only', function() {
    $day = new DateTime('01-01-2022');
    expect(CalendarService::getEmptyBeginDays($day, true))->toBe(5);

    $day = new DateTime('01-02-2022');
    expect(CalendarService::getEmptyBeginDays($day, true))->toBe(1);

    $day = new DateTime('01-05-2022');
    expect(CalendarService::getEmptyBeginDays($day, true))->toBe(5);

    $day = new DateTime('01-08-2022');
    expect(CalendarService::getEmptyBeginDays($day, true))->toBe(0);
});

it('returns empty end days with work days only', function() {
    $day = new DateTime('31-01-2022');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(4);

    $day = new DateTime('28-02-2022');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(4);

    $day = new DateTime('30-04-2022');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(0);

    $day = new DateTime('31-05-2022');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(3);

    $day = new DateTime('31-08-2022');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(2);

    $day = new DateTime('31-01-2020');
    expect(CalendarService::getEmptyEndDays($day, true))->toBe(0);
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

it('returns one day array for the same from-to dates without time', function() {
    $calendar = CalendarService::prepareCalendar('2021-12-1', '2021-12-1');
    $this->assertCount(1, $calendar);
});

it('returns one day array for the same from-to dates with the same time', function() {
    $calendar = CalendarService::prepareCalendar('2021-12-1 01:30', '2021-12-1 01:30');
    $this->assertCount(1, $calendar);
});

it('returns one day array for the same from-to dates with different time', function() {
    $calendar = CalendarService::prepareCalendar('2021-12-1 01:30', '2021-12-1 02:30');
    $this->assertCount(1, $calendar);
});

it('throws Exception when one of date doesnt exists', function() {
    CalendarService::prepareCalendar('2021-12-30', '2021-12-35');
})->throws(\Exception::class);

it('returns day names array', function() {
    expect(CalendarService::$dayNames)->toHaveKeys([1, 2, 3, 4, 5, 6, 7]);
});

it('returns month names array', function() {
    expect(CalendarService::$monthNames)->toHaveKeys([1, 2, 3, 4, 5, 6, 7, 9, 10, 11, 12]);
});

it('returns days array from different months', function() {
    $calendar = CalendarService::prepareCalendar('2021-08-1 01:30', '2021-09-30 02:30');
    $this->assertCount(61, $calendar);
});

it('returns days array from different years with leap year included', function() {
    $calendar = CalendarService::prepareCalendar('2020-01-01 01:30', '2021-12-31 02:30');
    $this->assertCount(2*365 + 1, $calendar);
});

it('returns days array from different ordinary years', function() {
    $calendar = CalendarService::prepareCalendar('2021-01-01 01:30', '2022-12-31 02:30');
    $this->assertCount(2*365, $calendar);
});

it('returns array with dates from array with dateTimes', function () {
   $dateTimes = [
       '2021-01-01 12:35',
       '2021-09-01 00:00:01',
   ];

   $parsed = CalendarService::parseArrayValuesToDate($dateTimes);

   $expected = [
       '2021-01-01',
       '2021-09-01',
   ];

   expect($parsed)->toEqual($expected);
});

it('skips invalid dateTime when parse to date', function () {
    $dateTimes = [
        '2021-13-01 12:35',
        '2021-12-01 00:00',
    ];

    $parsed = CalendarService::parseArrayValuesToDate($dateTimes);

    $expected = [
        '2021-12-01',
    ];

    expect($parsed)->toEqual($expected);
});

it('returns empty array when there is no datetimes', function () {
    $parsed = CalendarService::parseArrayValuesToDate([]);
    expect($parsed)->toEqual([]);
});

it('returns full weeks counter', function () {
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-01-2022')))->toBe(4);
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-02-2022')))->toBe(3);
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-05-2022')))->toBe(4);
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-08-2022')))->toBe(4);
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-11-2022')))->toBe(3);
    expect(CalendarService::getFullWeeksCounter(new \DateTime('01-05-2020')))->toBe(4);
});
