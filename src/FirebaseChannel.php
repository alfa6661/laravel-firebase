<?php

namespace Alfa6661\Firebase;

use Alfa6661\Firebase\Exceptions\CouldNotSendNotification;
use Config;
use Exception;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;
use RuntimeException;
use UnexpectedValueException;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{

    /**
     * @var paragraph1\phpFCM\Client
     */
    protected $client;

    /**
     * @var paragraph1\phpFCM\Message
     */
    protected $message;

    /**
     * Push Service constructor.
     *
     * @param paragraph1\phpFCM\Client $client
     * @param paragraph1\phpFCM\Message $message
     */
    public function __construct(Client $client, Message $message)
    {
        $this->client = $client;
        $this->message = $message;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $devices = $notifiable->routeNotificationFor('firebase');
        if (empty($devices)) {
            return;
        }

        $firebase = $notification->toFirebase($notifiable);

        try {
            foreach ($devices as $device) {
                $this->message->addRecipient(new Device($device))
                    ->setNotification($firebase->notification)
                    ->setData($firebase->data);

                $response = $this->client->send($this->message);
            }
        } catch (Exception $e) {

        }
    }

}
