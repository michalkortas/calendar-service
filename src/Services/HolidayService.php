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

        $easter = date('m-d', easter_date( $year ));
        $easterSec = date('m-d', strtotime('+1 day', strtotime( $year . '-' . $easter) ));
        #boze cialo
        $cc = date('m-d', strtotime('+60 days', strtotime( $year . '-' . $easter) ));
        #Zielone Świątki
        $p = date('m-d', strtotime('+49 days', strtotime( $year . '-' . $easter) ));

        $holidays = $constHolidays;
        $holidays[$easter] = 'Wielkanoc';
        $holidays[$easterSec] = 'Poniedziałek Wielkanocny';
        $holidays[$cc] = 'Boże Ciało';
        $holidays[$p] = 'Zielone Świątki';

        $month = $date->format('m-d');

        if($returnAll)
            return $holidays;

        if(array_key_exists($month, $holidays))
            return $holidays[$month];
        else
            return null;
    }

    public static function isWorkingDay(DateTime $date) {

        $dayOfWeek = $date->format('N');

        $saturday = 6;
        $sunday = 7;

        if( $dayOfWeek == $saturday || $dayOfWeek == $sunday ) {
            return false;
        }

        $holiday = self::getHoliday($date);

        if($holiday !== null)
            return false;

        return true;
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
