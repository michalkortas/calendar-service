<?php

namespace michalkortas\CalendarService\Services;

use DatePeriod;
use michalkortas\CalendarService\Domain\EventRange;
use michalkortas\CalendarService\Interfaces\RecurringTypeInterface;

class RecurringService
{
    public static function getRecurring(RecurringTypeInterface $recurring): array
    {
        $days = [];

        try {
            $fromDate = $recurring->getStartDate();
            $toDate = $recurring->getStopDateInterval();
            $duration = $recurring->getDuration();

            $period = new \DatePeriod($fromDate, $duration, $toDate);

            return self::getDays($period, $recurring);

        } catch (\Throwable $e) {
            return $days;
        }
    }

    public static function getValidInterval(int $daysInterval) : int {
        if($daysInterval < 0) {
            return 0;
        }

        return $daysInterval;
    }

    /**
     * @param DatePeriod $period
     * @param RecurringTypeInterface $recurring
     * @param array $days
     * @return array
     */
    private static function getDays(DatePeriod $period, RecurringTypeInterface $recurring): array
    {
        $days = [];

        foreach ($period as $datetime) {

            if(empty($recurring->getWeekDays())) {

                if($datetime > $recurring->getStartDate() &&
                    $datetime <= $recurring->getStopDate()) {
                    $day = (clone $datetime)->format('Y-m-d');

                    $days[$day] = self::getEventRange($day, $recurring);
                }

            } else {
                foreach ($recurring->getWeekDays() as $weekDay) {
                    $weekDayCode = CalendarService::$dayCodes[$weekDay];

                    $weekDayDateTime = (clone $datetime)->modify('next ' . $weekDayCode . ' this week');

                    if($weekDayDateTime > $recurring->getStartDate() &&
                        $weekDayDateTime <= $recurring->getStopDate()) {
                        $day = (clone $weekDayDateTime)->format('Y-m-d');

                        $days[$day] = self::getEventRange($day, $recurring);
                    }
                }

            }
        }
        return $days;
    }

    /**
     * @param string $day
     * @param RecurringTypeInterface $recurring
     * @return EventRange
     */
    private static function getEventRange(string $day, RecurringTypeInterface $recurring): EventRange
    {
        return new EventRange(
            $day . ' ' . $recurring->getEvent()->from_time,
            $day . ' ' . $recurring->getEvent()->to_time
        );
    }
}
