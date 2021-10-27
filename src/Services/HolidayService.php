<?php

namespace michalkortas\CalendarService\Services;

use DateTime;

class HolidayService
{
    public static function getHoliday(DateTime $date, bool $returnAll = false)
    {
        $year = $date->format('Y');

        $constHolidays = [
            '01-01' => 'Nowy rok',
            '01-06' => 'Święto Trzech Króli',
            '05-01' => 'Święto Pracy',
            '05-03' => 'Święto Konstytucji Trzeciego Maja',
            '08-15' => 'Wniebowzięcie Najświętszej Maryi Panny',
            '11-01' => 'Wszystkich Świętych',
            '11-11' => 'Dzień Niepodległości',
            '12-25' => 'Boże Narodzenie',
            '12-26' => 'Boże Narodzenie'
        ];

        $spring = (new \DateTime($year . '-03-21'))->setTime(0,0);

        $daysToEasterAfterSpring = easter_days($year);

        $easterDate = (clone $spring)->modify("+$daysToEasterAfterSpring days");

        $easter = (clone $easterDate)->format('m-d');

        $easterSec = (clone $easterDate)->modify('+1 day')->format('m-d');

        $corpusChristi = (clone $easterDate)->modify('+60 days')->format('m-d');

        $pentecost = (clone $easterDate)->modify('+49 days')->format('m-d');

        $holidays = $constHolidays;
        $holidays[$easter] = 'Wielkanoc';
        $holidays[$easterSec] = 'Poniedziałek Wielkanocny';
        $holidays[$corpusChristi] = 'Boże Ciało';
        $holidays[$pentecost] = 'Zesłanie Ducha Świętego';

        $month = $date->format('m-d');

        if($returnAll)
            return $holidays;

        if(array_key_exists($month, $holidays))
            return $holidays[$month];
        else
            return null;
    }

    public static function isWorkingDay(DateTime $date) {

        if ( self::isSaturday($date) || self::isSunday($date) || self::isHoliday($date) ) {
            return false;
        }

        return true;
    }

    public static function isSaturday(DateTime $date) {

        $dayOfWeek = $date->format('N');

        if( $dayOfWeek == 6 ) {
            return true;
        }

        return false;
    }

    public static function isSunday(DateTime $date) {

        $dayOfWeek = $date->format('N');

        if( $dayOfWeek == 7 ) {
            return true;
        }

        return false;
    }

    public static function isHoliday(DateTime $date) {

        $holiday = self::getHoliday($date);

        if ($holiday !== null)
            return true;

        return false;
    }

    public static function countWorkingDays(DateTime $dateFrom, DateTime $dateTo, bool $withStartDay = true) {

        if ($dateTo === $dateFrom && !$withStartDay)
            return 0;

        $char = 1;

        if ($dateFrom > $dateTo)
        {
            $dateTmp = $dateFrom;
            $dateFrom = $dateTo;
            $dateTo = $dateTmp;
            $char = -1;
        }

        $count = 0;

        if (!$withStartDay) {
            $dateFrom = (clone $dateFrom)->modify('+1 day');
        }

        $dateTo = (clone $dateTo)->modify('+1 day');

        while ($dateFrom < $dateTo) {
            if (self::isWorkingDay($dateFrom)) {
                $count++;
            }

            $dateFrom = (clone $dateFrom)->modify('+1 day');
        }
        $count *= $char;

        return $count;
    }
}
