<?php

namespace michalkortas\CalendarService\Domain;

class OnlineCalendarEvent
{
    /**
     * @var mixed|string
     */
    public $title;
    /**
     * @var mixed|string
     */
    public $color;
    /**
     * @var mixed|string
     */
    public $url;
    /**
     * @var mixed|null
     */
    public $from;
    /**
     * @var mixed|null
     */
    public $to;
    /**
     * @var mixed|null
     */
    public $unique_id;
    /**
     * @var mixed|null
     */
    public $created_at;
    /**
     * @var array|mixed
     */
    public $organizer;
    /**
     * @var array|mixed
     */
    public $attendees;
    /**
     * @var mixed|string
     */
    public $description;

    public function __construct(
        $from = null,
        $to = null,
        $title = '',
        $description = '',
        $organizer = [],
        $attendees = [],
        $uniqueId = null,
        $createdAt = null
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->from = $from;
        $this->to = $to;
        $this->organizer = $organizer;
        $this->attendees = $attendees;
        $this->unique_id = $uniqueId;
        $this->created_at = $createdAt;
    }
}
