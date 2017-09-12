<?php

namespace NotificationChannels\Flowroute;

use Illuminate\Http\Request;
use NotificationChannels\Flowroute\Exceptions\RequestIsNotAMessage;

/**
 * Class FlowrouteMessage
 * @package NotificationChannels\Flowroute
 */
class FlowrouteMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;
    public $to;
    public $id;

    /**
     * Create a new message instance.
     *
     * @param  string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @throws \NotificationChannels\Flowroute\Exceptions\RequestIsNotAMessage
     * @return $this
     */
    public function fromRequest(Request $request)
    {
        if (empty($request->data['type']) || $request->data['type'] !== 'message') {
            throw new RequestIsNotAMessage();
        }

        $data = $request->data['attributes'];
        $this->to = $data['to'];
        $this->from = $data['from'];
        $this->content($data['body']);

        return $this;
    }

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the phone number the message should be sent from.
     *
     * @param  string $from
     *
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function to($to)
    {
        $this->to = $to;

        return $this;
    }
}
