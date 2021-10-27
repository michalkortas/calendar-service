<?php

use michalkortas\CalendarService\Services\HolidayService;

it('returns all holidays from year', function () {
    $day = new DateTime('1999-04-04');

    ray(HolidayService::getHoliday($day, true));

    expect(count(HolidayService::getHoliday($day, true)))->toBe(13);
});

it('returns const holiday', function () {
    $day = new DateTime('1999-04-04');
    expect(HolidayService::getHoliday($day))->toBe('Nowy rok');
});

it('returns other holiday', function () {
    $day = new DateTime('2021-04-04');
    expect(HolidayService::getHoliday($day))->toBe('Wielkanoc');
});
