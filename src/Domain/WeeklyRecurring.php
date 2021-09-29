<?php

namespace michalkortas\CalendarService\Domain;

use DateInterval;
use DateTime;
use michalkortas\CalendarService\Interfaces\RecurringTypeInterface;
use michalkortas\CalendarService\Services\CalendarService;
use michalkortas\CalendarService\Services\RecurringService;

class WeeklyRecurring implements RecurringTypeInterface
{
    /**
     * @var DateTime
     */
    private $startDate;
    /**
     * @var DateTime
     */
    private $stopDate;
    /**
     * @var int
     */
    private $interval;
    /**
     * @var array|null
     */
    private $weekDays;
    /**
     * @var CalendarEvent
     */
    private $event;

    public function __construct(
            CalendarEvent $event,
            DateTime $stopDate = null,
            int $interval = 0,
            array $weekDays = [],
            DateTime $startDate = null
        ) {

        $this->startDate = $startDate;
        $this->stopDate = $stopDate;
        $this->interval = $interval;
        $this->weekDays = $weekDays;
        $this->event = $event;
    }

    public function getStartDate(): DateTime
    {
        try {
            if ($this->startDate === null)
                return (new DateTime($this->event->from))->setTime(0,0);

            return $this->startDate->setTime(0,0);
        } catch (\Throwable $e) {
            return (new DateTime())->setTime(0,0);
        }
    }

    public function getStopDate(): DateTime
    {
        try {
            if ($this->stopDate === null) {
                $stopDate = (new DateTime($this->event->to))->setTime(0, 0);
            } else {
                $stopDate = $this->stopDate->setTime(0,0);
            }

            return $stopDate;

        } catch (\Throwable $e) {
            return (new DateTime())->setTime(0,0);
        }
    }

    public function getStopDateInterval(): DateTime
    {
        try {
            if ($this->stopDate === null) {
                $stopDate = (new DateTime($this->event->to))->setTime(0, 0);
            } else {
                $stopDate = $this->stopDate->setTime(0,0);
            }

            if(!empty($this->getWeekDays())) {
                $stopDate = (clone $stopDate)->modify('next sunday');
            }

            return $stopDate;

        } catch (\Throwable $e) {
            return (new DateTime())->setTime(0,0);
        }
    }

    public function getInterval(): int
    {
        return RecurringService::getValidInterval($this->interval);
    }

    public function getWeekDays(): array
    {
        return CalendarService::getValidWeekDays($this->weekDays);
    }

    public function getType(): string
    {
        return 'weekly';
    }

    public function getEvent(): CalendarEvent
    {
        return $this->event;
    }

    public function getDuration(): DateInterval
    {
        try {
            return new DateInterval('P' . $this->getInterval() . 'W' );
        } catch (\Throwable $e) {
            return new DateInterval('P1W' );
        }

    }

    public function getDays(): array
    {
        return RecurringService::getRecurring($this);
    }
}
