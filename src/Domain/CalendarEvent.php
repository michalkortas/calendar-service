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
    public $description_title;
    /**
     * @var mixed|string
     */
    public $description_content;
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
    public $url_edit;
    /**
     * @var mixed|string
     */
    public $url_show;
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
    public $created_user;
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
    public $text_color;
    /**
     * @var mixed|null
     */
    public $unique_id;
    /**
     * @var mixed|null
     */
    public $created_at;
    /**
     * @var mixed|null
     */
    public $origin;

    public function __construct(
        $from = null,
        $to = null,
        $createdUser = null,
        $title = '',
        $descriptionTitle = '',
        $descriptionContent = '',
        $urlEdit = '#',
        $urlShow = '#',
        $color = '',
        $textColor = '',
        $icon = null,
        $uniqueId = null,
        $createdAt = null,
        $origin = null
    )
    {
        $this->title = $title;
        $this->description_title = $descriptionTitle;
        $this->description_content = $descriptionContent;
        $this->url_edit = $urlEdit;
        $this->url_show = $urlShow;
        $this->color = $color;
        $this->text_color = $textColor;
        $this->icon = $icon;
        $this->from = $from;
        $this->to = $to;
        $this->from_time = $from !== null ? (new \DateTime($from))->format('H:i') : null;
        $this->to_time = $to !== null ? (new \DateTime($to))->format('H:i') : null;
        $this->created_user = $createdUser;
        $this->unique_id = $uniqueId;
        $this->created_at = $createdAt;
        $this->origin = $origin;
    }
}
