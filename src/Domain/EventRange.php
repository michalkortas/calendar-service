<?php

namespace michalkortas\CalendarService\Domain;

class EventRange
{
    public $from;
    public $to;

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
