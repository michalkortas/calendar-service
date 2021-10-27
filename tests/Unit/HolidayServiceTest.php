<?php

use michalkortas\CalendarService\Services\HolidayService;

it('returns all holidays from year', function () {
    $day = new DateTime('1999-04-04');
    expect(count(HolidayService::getHoliday($day, true)))->toBe(13);
});

it('returns const holiday new year', function () {
    $day = new DateTime('2021-01-01');
    expect(HolidayService::getHoliday($day))->toBe('Nowy rok');
});

it('returns movable holiday easter', function () {
    $day = new DateTime('2021-04-04');
    expect(HolidayService::getHoliday($day))->toBe('Wielkanoc');
});

test('is working day saturday', function () {
    $day = new DateTime('2021-10-30');
    expect(HolidayService::isWorkingDay($day))->toBeFalse();
});

test('is working day sunday', function () {
    $day = new DateTime('2021-10-31');
    expect(HolidayService::isWorkingDay($day))->toBeFalse();
});

test('is working day new year const holiday', function () {
    $day = new DateTime('2021-01-01');
    expect(HolidayService::isWorkingDay($day))->toBeFalse();
});

test('is working day easter movable holiday', function () {
    $day = new DateTime('2021-04-04');
    expect(HolidayService::isWorkingDay($day))->toBeFalse();
});

test('is not working day', function () {
    $day = new DateTime('2021-01-04');
    expect(HolidayService::isWorkingDay($day))->toBeTrue();
});

test('count working days during an ordinary week with start day', function () {
    $from = new DateTime('2021-10-25');
    $to = new DateTime('2021-10-31');
    expect(HolidayService::countWorkingDays($from, $to))->toBe(5);
});

test('count working days during an ordinary week without start day', function () {
    $from = new DateTime('2021-10-25');
    $to = new DateTime('2021-10-31');
    expect(HolidayService::countWorkingDays($from, $to, false))->toBe(4);
});

test('count working days during christmas week', function () {
    $from = new DateTime('2019-12-23');
    $to = new DateTime('2019-12-29');
    expect(HolidayService::countWorkingDays($from, $to))->toBe(3);
});

test('count working days during easter weeks', function () {
    $from = new DateTime('2021-03-29');
    $to = new DateTime('2021-04-11');
    expect(HolidayService::countWorkingDays($from, $to))->toBe(9);
});
