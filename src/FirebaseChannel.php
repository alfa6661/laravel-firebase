<?php

namespace Alfa6661\Firebase;

use Exception;
use paragraph1\phpFCM\Client;
use paragraph1\phpFCM\Message;
use paragraph1\phpFCM\Recipient\Device;
use Illuminate\Notifications\Notification;

class FirebaseChannel
{
    /**
     * @var paragraph1\phpFCM\Client
     */
    protected $client;

    /**
     * Push Service constructor.
     *
     * @param paragraph1\phpFCM\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
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
                $message = (new Message())
                    ->addRecipient(new Device($device))
                    ->setNotification($firebase->notification)
                    ->setData($firebase->data);

                $this->client->send($message);
            }
        } catch (Exception $e) {
        }
    }
}
