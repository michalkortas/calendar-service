<?php

use michalkortas\CalendarService\Services\RecurringService;

it('returns 0 if interval < 0', function () {
    expect(RecurringService::getValidInterval(-1))->toBe(0);
});

it('returns 0 if interval equals 0', function () {
    expect(RecurringService::getValidInterval(0))->toBe(0);
});

it('returns interval if interval is more than 0', function () {
    expect(RecurringService::getValidInterval(0))->toBe(0);
});

it('returns integer if interval is double', function () {
    expect(RecurringService::getValidInterval(4.6))->toBe(4);
});
