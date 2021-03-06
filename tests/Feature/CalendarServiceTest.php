<?php

use michalkortas\CalendarService\Services\CalendarService;

it('returns week instance', function() {
    $instance = CalendarService::getWeekInstance();

    expect($instance)
        ->toHaveKeys(['days', 'nextWeek', 'lastWeek']);
});

it('returns current month instance if date is not provided', function() {
    $instance = CalendarService::getMonthInstance();

    expect($instance['monthCode'])->toBe((new DateTime())->format('Y-m'));
});

it('returns valid month instance if date is provided', function() {
    $instance = CalendarService::getMonthInstance(new DateTime('2021-12-12'));

    expect($instance['monthCode'])->toBe((new DateTime('2021-12-12'))->format('Y-m'));
});

it('returns valid array keys in month instance', function() {
    $instance = CalendarService::getMonthInstance();

    expect($instance)
        ->toHaveKeys(['days', 'emptyBegin', 'emptyEnd', 'emptyWorkDaysBegin', 'emptyWorkDaysEnd', 'endTo', 'firstDay', 'isTodayVisible', 'lastDay', 'lastMonth', 'lastMonthCode', 'monthCode', 'monthName', 'nextMonth', 'nextMonthCode', 'startFrom', 'today', 'todayDay', 'year', 'monthNumber', 'daysInstances', 'fullWeeksCounter']);
});

it('returns valid days instances in month instance', function() {
    $month = new DateTime('2021-10-01');
    $instance = CalendarService::getMonthInstance($month);

    expect(count($instance['daysInstances']))->toBe($instance['days']);
});

it('returns valid day keys in day instance', function() {
    $instance = CalendarService::getDayInstance();

    expect($instance)->toHaveKeys(['dayName', 'weekNumber', 'weekDayNumber', 'nextName', 'lastName', 'year', 'today', 'todayDay', 'nextDay', 'currentDay', 'lastDay', 'nextDayCode', 'currentDayCode', 'lastDayCode', 'monthCode', 'dayCode', 'startFrom', 'endTo', 'isWorkingDay', 'isSaturday', 'isSunday', 'isHoliday']);
});
