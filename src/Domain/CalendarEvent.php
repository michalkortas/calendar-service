<?php

namespace michalkortas\CalendarService\Domain;

class CalendarEvent
{
    /**
     * @var mixed|string
     */
    public $title;
    /**
     * @var mixed|string
     */
    public $descriptionTitle;
    /**
     * @var mixed|string
     */
    public $descriptionContent;
    /**
     * @var mixed|string
     */
    public $color;
    /**
     * @var mixed|string
     */
    public $icon;
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
    public $createdUser;

    public function __construct(
        $from = null,
        $to = null,
        $createdUser = null,
        $title = '',
        $descriptionTitle = '',
        $descriptionContent = '',
        $url = '#',
        $color = '',
        $icon = null
    )
    {
        $this->title = $title;
        $this->descriptionTitle = $descriptionTitle;
        $this->descriptionContent = $descriptionContent;
        $this->url = $url;
        $this->color = $color;
        $this->icon = $icon;
        $this->from = $from;
        $this->to = $to;
        $this->createdUser = $createdUser;
    }
}
