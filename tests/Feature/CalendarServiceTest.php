<?php
use michalkortas\CalendarService\Services\CalendarService;

it('returns current month instance if date is not provided', function() {
    $instance = CalendarService::getMonthInstance();

    expect($instance['monthCode'])->toBe((new DateTime())->format('Y-m'));
});

it('returns valid month instance if date is provided', function() {
    $instance = CalendarService::getMonthInstance(new DateTime('2021-12-12'));

    expect($instance['monthCode'])->toBe((new DateTime('2021-12-12'))->format('Y-m'));
});
