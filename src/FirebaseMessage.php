<?php

namespace Alfa6661\Firebase;

use paragraph1\phpFCM\Notification;

class FirebaseMessage
{

    public $notification;

    public $data = [];

    /**
     * @param string $body
     *
     * @return static
     */
    public static function create($title = '', $body = '')
    {
        return new static($title, $body);
    }

    /**
     * @param string $body
     */
    public function __construct($title = '', $body = '')
    {
        $this->notification = new Notification($title, $body);
        $this->notification->setSound('default');

        $this->body = $body;
    }

    /**
     * Set the message body.
     *
     * @param string $value
     *
     * @return $this
     */
    public function body($value)
    {
        $this->notification->setBody($value);

        return $this;
    }

    /**
     * Set the message title.
     *
     * @param string $value
     *
     * @return $this
     */
    public function title($value)
    {
        $this->notification->setTitle($value);

        return $this;
    }

    public function sound($value = 'default')
    {
        $this->notification->setSound($value);

        return $this;
    }

    public function data(array $values = [])
    {
        $this->data = $values;

        return $this;
    }

}
