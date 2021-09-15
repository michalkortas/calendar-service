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
    public $uniqueId;
    /**
     * @var mixed|null
     */
    public $createdAt;
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
        $this->uniqueId = $uniqueId;
        $this->createdAt = $createdAt;
    }

    private $statuses = [
        'accepted',
        'declined',
        'needs_action',
    ];
}
