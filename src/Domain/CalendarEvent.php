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
    /**
     * @var string
     */
    public $from_time;
    /**
     * @var string
     */
    public $to_time;
    /**
     * @var mixed|string
     */
    public $textColor;
    /**
     * @var mixed|null
     */
    public $uniqueId;
    /**
     * @var mixed|null
     */
    public $createdAt;

    public function __construct(
        $from = null,
        $to = null,
        $createdUser = null,
        $title = '',
        $descriptionTitle = '',
        $descriptionContent = '',
        $url = '#',
        $color = '',
        $textColor = '',
        $icon = null,
        $uniqueId = null,
        $createdAt = null
    )
    {
        $this->title = $title;
        $this->descriptionTitle = $descriptionTitle;
        $this->descriptionContent = $descriptionContent;
        $this->url = $url;
        $this->color = $color;
        $this->textColor = $textColor;
        $this->icon = $icon;
        $this->from = $from;
        $this->to = $to;
        $this->from_time = $from !== null ? (new \DateTime($from))->format('H:i') : null;
        $this->to_time = $to !== null ? (new \DateTime($to))->format('H:i') : null;
        $this->createdUser = $createdUser;
        $this->uniqueId = $uniqueId;
        $this->createdAt = $createdAt;
    }
}
