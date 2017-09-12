<?php

namespace NotificationChannels\Flowroute;

use NotificationChannels\Flowroute\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class FlowrouteChannel
{
    /**
     * @var \NotificationChannels\Flowroute\Flowroute;
     */
    protected $flowroute;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */
    protected $from;

    /**
     * FlowrouteChannel constructor.
     *
     * @param \NotificationChannels\Flowroute\Flowroute $flowroute
     */
    public function __construct(Flowroute $flowroute)
    {
        $this->flowroute = $flowroute;
        $this->from = $this->flowroute->from();
    }

    /**
     * Send the given notification.
     *
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws \NotificationChannels\Flowroute\Exceptions\CouldNotSendNotification
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('flowroute')) {
            return;
        }

        $message = $notification->toFlowroute($notifiable);

        if (empty($message)) {
            return;
        } else if (is_string($message)) {
            $message = new FlowrouteMessage($message);
        }

        $response = $this->flowroute->sendSms([
            'from' => $message->from ?: $this->from,
            'to' => $to,
            'body' => trim($message->content),
            'dlr_callback' => $this->flowroute->webhook_url
        ]);

        if ($response->getStatusCode() !== 202) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }

        return $response;
    }
}
