<?php

namespace michalkortas\CalendarService\Domain;

class EventRange
{
    public $to;
    public $from;

    public function __construct(string $from, string $to)
    {
        try {
            $this->from = new \DateTime($from);
            $this->to = new \DateTime($to);
        } catch (\Throwable $e) {
            $this->from = null;
            $this->to = null;
        }

    }
}
