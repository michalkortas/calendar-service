<?php

use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\MonthlyRecurring;
use michalkortas\CalendarService\Services\WorkCalendarService;

it('returns nominal work days in month', function () {
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-01-2020')))->toBe(21);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-02-2020')))->toBe(20);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-03-2020')))->toBe(22);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-04-2020')))->toBe(21);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-05-2020')))->toBe(20);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-06-2020')))->toBe(21);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-07-2020')))->toBe(23);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-08-2020')))->toBe(20);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-09-2020')))->toBe(22);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-10-2020')))->toBe(22);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-11-2020')))->toBe(20);
    expect(WorkCalendarService::getNominalWorkDays(new DateTime('01-12-2020')))->toBe(21);
});

it('returns nominal work hours in month', function () {
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-01-2020')))->toBe(168);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-02-2020')))->toBe(160);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-03-2020')))->toBe(176);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-04-2020')))->toBe(168);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-05-2020')))->toBe(160);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-06-2020')))->toBe(168);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-07-2020')))->toBe(184);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-08-2020')))->toBe(160);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-09-2020')))->toBe(176);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-10-2020')))->toBe(176);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-11-2020')))->toBe(160);
    expect(WorkCalendarService::getNominalWorkHours(new DateTime('01-12-2020')))->toBe(168);
});
