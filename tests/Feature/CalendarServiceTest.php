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

test('group dates from the same month', function () {
    $dates = ["2023-06-19", "2023-06-21", "2023-06-23", "2023-06-23", "2023-06-24", "2023-06-18"];

    $sortedAndGroupedDates = CalendarService::groupDates($dates);

    expect($sortedAndGroupedDates)->toBe([
        0 => [
           0 => "2023-06-18",
           1 => "2023-06-19",
        ],
        1 => [
           0 => "2023-06-21",
        ] ,
        2 => [
           0 => "2023-06-23",
           1 => "2023-06-24",
        ]
    ]);
});

test('group dates from different months without splitting', function () {
    $dates = ["2023-07-30", "2023-08-01", "2023-07-31", "2023-08-02", "2023-08-03", "2023-08-23", "2023-08-24"];

    $sortedAndGroupedDates = CalendarService::groupDates($dates);

    expect($sortedAndGroupedDates)->toBe([
        0 => [
           0 => "2023-07-30",
           1 => "2023-07-31",
           2 => "2023-08-01",
           3 => "2023-08-02",
           4 => "2023-08-03",
        ] ,
        1 => [
           0 => "2023-08-23",
           1 => "2023-08-24",
        ]
    ]);
});

test('group dates from different months with splitting', function () {
    $dates = ["2023-07-30", "2023-08-01", "2023-07-31", "2023-08-02", "2023-08-03", "2023-08-23", "2023-08-24"];

    $sortedAndGroupedDates = CalendarService::groupDates($dates, true);

    expect($sortedAndGroupedDates)->toBe([
        0 => [
           0 => "2023-07-30",
           1 => "2023-07-31",
        ],
        1 => [
           0 => "2023-08-01",
           1 => "2023-08-02",
           2 => "2023-08-03",
        ] ,
        2 => [
           0 => "2023-08-23",
           1 => "2023-08-24",
        ]
    ]);
});
