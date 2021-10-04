<?php
namespace michalkortas\CalendarService\Interfaces;

use DateInterval;
use DateTime;
use michalkortas\CalendarService\Domain\CalendarEvent;
use michalkortas\CalendarService\Domain\EventRange;

interface RecurringTypeInterface
{
    public function getStartDate() : DateTime;
    public function getStopDate() : DateTime;
    public function getStopDateInterval() : DateTime;
    public function getInterval() : int;
    public function getDuration() : DateInterval;
    public function getWeekDays() : array;
    public function getType() : string;
    public function getDays() : array;
    public function getOrigin() : EventRange;
    public function getEvent() : CalendarEvent;
}
