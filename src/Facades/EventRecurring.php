<?php

namespace michalkortas\CalendarService\Facades;

use DateTime;
use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\DailyRecurring;
use michalkortas\CalendarService\Domain\MonthlyRecurring;
use michalkortas\CalendarService\Domain\WeeklyRecurring;
use michalkortas\CalendarService\Domain\YearlyRecurring;

class EventRecurring
{
    public static function getDailyRecurring(
        \DateTime $eventFrom,
        \DateTime $eventTo,
        \DateTime $stopRecurring,
        int $interval = 0,
        array $weekDays = [],
        array $excludedDays = [],
        \DateTime $startRecurringDate = null
    ): DailyRecurring
    {
        list($stopRecurringDate, $baseEvent) = self::prepareRecurringData(
            $eventFrom, $eventTo, $stopRecurring
        );

        return new DailyRecurring($baseEvent, $stopRecurringDate, $interval, $weekDays, $excludedDays);
    }

    public static function getWeeklyRecurring(
        \DateTime $eventFrom,
        \DateTime $eventTo,
        \DateTime $stopRecurring,
        int $interval = 0,
        array $weekDays = [],
        array $excludedDays = [],
        \DateTime $startRecurringDate = null
    ): WeeklyRecurring
    {
        list($stopRecurringDate, $baseEvent) = self::prepareRecurringData(
            $eventFrom, $eventTo, $stopRecurring
        );

        return new WeeklyRecurring($baseEvent, $stopRecurringDate, $interval, $weekDays, $excludedDays, $startRecurringDate);
    }

    public static function getMonthlyRecurring(
        \DateTime $eventFrom,
        \DateTime $eventTo,
        \DateTime $stopRecurring,
        int $interval = 0,
        array $weekDays = [],
        array $excludedDays = [],
        \DateTime $startRecurringDate = null
    ): MonthlyRecurring
    {
        list($stopRecurringDate, $baseEvent) = self::prepareRecurringData(
            $eventFrom, $eventTo, $stopRecurring
        );

        return new MonthlyRecurring($baseEvent, $stopRecurringDate, $interval, $weekDays, $excludedDays, $startRecurringDate);
    }

    public static function getYearlyRecurring(
        \DateTime $eventFrom,
        \DateTime $eventTo,
        \DateTime $stopRecurring,
        int $interval = 0,
        array $weekDays = [],
        array $excludedDays = [],
        \DateTime $startRecurringDate = null
    ): YearlyRecurring
    {
        list($stopRecurringDate, $baseEvent) = self::prepareRecurringData(
            $eventFrom, $eventTo, $stopRecurring
        );

        return new YearlyRecurring($baseEvent, $stopRecurringDate, $interval, $weekDays, $excludedDays, $startRecurringDate);
    }

    /**
     * @param DateTime $eventFrom
     * @param DateTime $eventTo
     * @param DateTime $stopRecurring
     * @return array
     */
    private static function prepareRecurringData(DateTime $eventFrom, DateTime $eventTo, DateTime $stopRecurring): array
    {
        $from = $eventFrom->format('Y-m-d H:i');
        $to = $eventTo->format('Y-m-d H:i');
        $stopRecurringDate = $stopRecurring;

        $baseEvent = new CalendarEvent($from, $to);

        return array($stopRecurringDate, $baseEvent);
    }
}
