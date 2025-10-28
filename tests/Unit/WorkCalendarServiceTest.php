<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\MonthlyRecurring;
use michalkortas\CalendarService\Services\WorkCalendarService;

it('returns nominal work days in month', function () {
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-01-2020')))->toBe(21)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-02-2020')))->toBe(20)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-03-2020')))->toBe(22)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-04-2020')))->toBe(21)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-05-2020')))->toBe(20)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-06-2020')))->toBe(21)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-07-2020')))->toBe(23)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-08-2020')))->toBe(20)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-09-2020')))->toBe(22)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-10-2020')))->toBe(22)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-11-2020')))->toBe(20)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-12-2020')))->toBe(21)
        ->and(WorkCalendarService::getNominalWorkDays(new DateTime('01-12-2025')))->toBe(20);
});

it('returns nominal work hours in month', function () {
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-01-2020')))->toBe(168)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-02-2020')))->toBe(160)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-03-2020')))->toBe(176)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-04-2020')))->toBe(168)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-05-2020')))->toBe(160)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-06-2020')))->toBe(168)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-07-2020')))->toBe(184)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-08-2020')))->toBe(160)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-09-2020')))->toBe(176)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-10-2020')))->toBe(176)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-11-2020')))->toBe(160)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-12-2020')))->toBe(168)
        ->and(WorkCalendarService::getNominalWorkHours(new DateTime('01-12-2025')))->toBe(160);
});

it('checks night shift hours', function() {
    expect(WorkCalendarService::hasNightShiftHours([
        'start' => '03:30:00',
        'stop' => '06:00:00',
    ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '22:00:00',
            'stop' => '06:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '22:00:00',
            'stop' => '04:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '20:00:00',
            'stop' => '04:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '04:00:00',
            'stop' => '09:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '20:00:00',
            'stop' => '18:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '20:00:00',
            'stop' => '20:00:00',
        ]))->toBeFalse()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '23:00:00',
            'stop' => '23:00:00',
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '06:00:00',
            'stop' => '14:00:00',
        ]))->toBeFalse()
        ->and(WorkCalendarService::hasNightShiftHours([
            'start' => '18:00:00',
            'stop' => '22:00:00',
        ]))->toBeFalse()
        ->and(WorkCalendarService::hasNightShiftHours([
            "start" => "02:00:00",
            "stop" => "05:45:00"
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            "start" => "02:00:00",
            "stop" => "06:00:00"
        ]))->toBeTrue()
        ->and(WorkCalendarService::hasNightShiftHours([
            "start" => "22:30:00",
            "stop" => "23:30:00"
        ]))->toBeTrue();

});
