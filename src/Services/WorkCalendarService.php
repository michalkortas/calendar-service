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
}
