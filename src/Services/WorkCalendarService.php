<?php

namespace michalkortas\CalendarService\Services;

use DateTime;

class WorkCalendarService
{
    const WORK_DAYS_IN_WEEK = 5;

    public static function getNominalWorkDays(DateTime $dateTime) {
        $monthInstance = CalendarService::getMonthInstance($dateTime);

        $weeks = $monthInstance['fullWeeksCounter'];
        $days = $weeks * self::WORK_DAYS_IN_WEEK;

        $allDaysOnEnd = $monthInstance['emptyEnd'];
        $allDaysOnStart = $monthInstance['emptyBegin'];

        $workDaysOnEnd = 0;
        $workDaysOnStart = 0;

        if($allDaysOnEnd > 0) {
            $workDaysOnEnd = self::WORK_DAYS_IN_WEEK - $monthInstance['emptyWorkDaysEnd'];
        }

        if($allDaysOnStart > 0) {
            $workDaysOnStart = self::WORK_DAYS_IN_WEEK - $monthInstance['emptyWorkDaysBegin'];;
        }

        $notSundayHolidayDays = count(self::getNotSundayHolidays($dateTime));

        return $days + $workDaysOnEnd + $workDaysOnStart - $notSundayHolidayDays;

    }

    public static function getNominalWorkHours(DateTime $dateTime, int $dailyHours = 8) {
        return self::getNominalWorkDays($dateTime) * $dailyHours;
    }

    private static function getNotSundayHolidays(DateTime $dateTime)
    {
        $holidays = HolidayService::getHoliday($dateTime, true);
        $notSundayHolidays = [];

        $year = (clone $dateTime)->format('Y');
        $begin = (clone $dateTime)->modify('first day of this month');
        $end = (clone $dateTime)->modify('last day of this month');

        foreach($holidays ?? [] as $holidayDate => $name) {
            $date = new \DateTime($year . '-' . $holidayDate);

            if((clone $date)->format('N') != 7 && ($date >= $begin && $date <= $end)) {
                $notSundayHolidays[(clone $date)->format('Y-m-d')] = $name;
            }
        }

        return $notSundayHolidays;
    }

    /**
     * @throws \Exception
     */
    public static function hasNightShiftHours(array $array)
    {
        $range = array_values($array);

        $startTimeHour = explode(':', $range[0])[0];
        $stopTimeHour = explode(':', $range[1])[0];

        $date = (new \DateTime())->format('Y-m-d');

        if($startTimeHour >= 22 && $stopTimeHour >= 22 ) {
            $date = (new \DateTime('-1 day'))->format('Y-m-d');
        }

        $startTime = new \DateTime($date . ' ' . $range[0]);
        $stopTime = new \DateTime($date . ' ' . $range[1]);


        $startShift = (new \DateTime())->modify('-1 day')->setTime(22, 0);
        $stopShift = (new \DateTime())->setTime(6, 0);

        if($startTime > $stopTime) {
            $newDate = (new \DateTime('-1 day'))->format('Y-m-d');
            $startTime = new \DateTime($newDate . ' ' . $range[0]);
        }

        return (($startShift >= $startTime && $startShift <= $stopTime) ||
            ($stopShift > $startTime && $stopShift <= $stopTime) ||
            ($startTime >= $startShift && $startTime < $stopShift) ||
            ($stopTime >= $startShift && $stopTime <= $stopShift)
        );
    }
}
