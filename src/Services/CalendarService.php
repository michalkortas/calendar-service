<?php

namespace michalkortas\CalendarService\Services;

use DateInterval;
use DatePeriod;
use DateTime;
use http\Exception;

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
            'monthCode' => (clone $firstDay)->format('Y-m'),
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
            'dayName' => self::$dayNames[(clone $today)->format('N')],
            'nextName' => self::$dayNames[(clone $nextDay)->format('N')],
            'lastName' => self::$dayNames[(clone $lastDay)->format('N')],
            'year' => (int)(clone $today)->format('Y'),
            'today' => (clone $today)->format('Y-m-d'),
            'todayDay' => (clone $today)->format('j'),
            'nextDay' => (clone $nextDay)->format('Y-m-d'),
            'lastDay' => (clone $lastDay)->format('Y-m-d'),
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

}
