<?php

namespace michalkortas\CalendarService\Services;

use DateInterval;
use DatePeriod;
use DateTime;

class CalendarService
{

    public static function getMonthInstance(\DateTime $date = null): array
    {
        if($date === null) {
            $date = new \DateTime();
        }

        $today = new \DateTime();

        $firstDayTodayMonth = (clone $today)->modify('first day of this month');
        $firstDay = (clone $date)->modify('first day of this month');
        $lastDay = (clone $date)->modify('last day of this month');

        $nextMonth = (clone $date)->modify('next month');
        $lastMonth = (clone $date)->modify('last month');

        return [
            'days' => (int)(clone $date)->format('t'),
            'emptyBegin' => self::getEmptyBeginDays(clone $firstDay),
            'emptyEnd' => self::getEmptyEndDays(clone $lastDay),
            'monthName' => self::$monthNames[(clone $firstDay)->format('n')],
            'startFrom' => (clone $firstDay)->format('Y-m-d'),
            'endTo' => (clone $lastDay)->format('Y-m-d'),
            'year' => (int)(clone $firstDay)->format('Y'),
            'today' => (clone $today)->format('Y-m-d'),
            'todayDay' => (clone $today)->format('j'),
            'isTodayVisible' => (clone $firstDay)->format('Y-m-d') === (clone $firstDayTodayMonth)->format('Y-m-d'),
            'nextMonth' => (clone $nextMonth)->format('Y-m-d'),
            'nextMonthCode' => (clone $nextMonth)->format('Y-m'),
            'lastMonth' => (clone $lastMonth)->format('Y-m-d'),
            'lastMonthCode' => (clone $lastMonth)->format('Y-m'),
            'firstDay' => (clone $firstDay)->format('Y-m-d'),
            'lastDay' => (clone $lastDay)->format('Y-m-d'),
            'firstDayDateTime' => (clone $firstDay)->format('Y-m-d 00:00:00'),
            'lastDayDateTime' => (clone $lastDay)->format('Y-m-d 23:59:59'),
            'monthCode' => (clone $firstDay)->format('Y-m'),
            'monthNumber' => (clone $firstDay)->format('m'),
            'daysInstances' => self::getDaysInstances($firstDay, $lastDay)
        ];
    }

    public static function getDayInstance(\DateTime $date = null): array
    {
        if($date === null) {
            $date = new \DateTime();
        }

        $today = new \DateTime();

        $nextDay = (clone $date)->modify('next day');
        $lastDay = (clone $date)->modify('last day');

        return [
            'dayName' => self::$dayNames[(clone $date)->format('N')],
            'nextName' => self::$dayNames[(clone $nextDay)->format('N')],
            'lastName' => self::$dayNames[(clone $lastDay)->format('N')],
            'year' => (int)(clone $date)->format('Y'),
            'today' => (clone $today)->format('Y-m-j'),
            'todayDay' => (clone $date)->format('j'),
            'currentDay' => (clone $date)->format('Y-m-j'),
            'nextDay' => (clone $nextDay)->format('Y-m-j'),
            'lastDay' => (clone $lastDay)->format('Y-m-j'),
            'currentDayCode' => (clone $date)->format('Y-m-d'),
            'nextDayCode' => (clone $nextDay)->format('Y-m-d'),
            'lastDayCode' => (clone $lastDay)->format('Y-m-d'),
            'monthCode' => (clone $lastDay)->format('Y-m'),
            'weekNumber' => (clone $date)->format('W'),
            'weekDayNumber' => (clone $date)->format('N'),
            'startFrom' => (clone $date)->setTime(0, 0)->format('Y-m-d H:i:s'),
            'endTo' => (clone $date)->setTime(23, 59, 59)->format('Y-m-d H:i:s'),
            'dayNumber' => (clone $date)->format('d'),
            'isWorkingDay' => HolidayService::isWorkingDay($date),
            'isSaturday' => HolidayService::isSaturday($date),
            'isSunday' => HolidayService::isSunday($date),
            'isHoliday' => HolidayService::isHoliday($date),
        ];
    }

    public static function getEmptyBeginDays(\DateTime $firstDay) {
        $weekDay = $firstDay->format('w');

        if($weekDay == 0) {
            return 6;
        } else {
            return $weekDay-1;
        }
    }

    public static function getEmptyEndDays(\DateTime $lastDay) {
        $weekDay = $lastDay->format('w');

        if($weekDay > 0) {
            return 7-$weekDay;
        }

        return 0;
    }

    public static $dayNames = [
        1 => 'Poniedziałek',
        2 => 'Wtorek',
        3 => 'Środa',
        4 => 'Czwartek',
        5 => 'Piątek',
        6 => 'Sobota',
        7 => 'Niedziela',
    ];

    public static $dayCodes = [
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        7 => 'sunday',
    ];

    public static $monthNames = [
        1 => 'Styczeń',
        2 => 'Luty',
        3 => 'Marzec',
        4 => 'Kwiecień',
        5 => 'Maj',
        6 => 'Czerwiec',
        7 => 'Lipiec',
        8 => 'Sierpień',
        9 => 'Wrzesień',
        10 => 'Październik',
        11 => 'Listopad',
        12 => 'Grudzień',
    ];

    /**
     * @throws \Exception
     */
    public static function getValidDate($date): DateTime
    {
        try {
            if($date !== null) {
                return new DateTime($date);
            }
            return new DateTime();
        } catch (\Throwable $e) {
            throw new \Exception('Bad date was passed.');
        }
    }

    /**
     * @throws \Exception
     */
    public static function prepareCalendar($from, $to): array
    {
        $calendar = [];

        try {
            $begin = (new DateTime($from))->setTime(0, 0);
            $end = (new DateTime($to))->setTime(0, 0);
            $end = $end->modify( '+1 day');

            $interval = new DateInterval('P1D');
            $range = new DatePeriod($begin, $interval, $end);
        } catch (\Throwable $e) {
            throw new \Exception('Bad date was passed.');
        }

        foreach($range ?? [] as $date){
            $calendar[$date->format("Y-m-j")] = [];
        }

        return $calendar;
    }

    public static function getValidWeekDays(array $weekDays) : array
    {
        return $weekDays;
    }

    public static function parseArrayValuesToDate(array $datetimeArray): array
    {
        $dates = [];

        foreach ($datetimeArray ?? [] as $datetime) {
            try {
                $dates[] = (new DateTime($datetime))->format('Y-m-d');
            } catch (\Throwable $e) {
                continue;
            }
        }

        return $dates;
    }

    private static function getDaysInstances(DateTime $firstDay, DateTime $lastDay)
    {
        $days = [];

        $firstDay->setTime(0, 0);
        $lastDay->setTime(0, 1);

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($firstDay, $interval, $lastDay);

        foreach ($period as $date) {
            $day = new \DateTime((clone $date)->format('Y-m-d'));
            $days[(clone $date)->format('j')] = self::getDayInstance($day);
        }

        return $days;
    }

}
