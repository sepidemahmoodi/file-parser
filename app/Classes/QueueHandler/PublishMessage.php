<?php
namespace App\Classes\QueueHandler;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class PublishMessage
{
    private $connection;
    private $channel;

    /**
     * ConsumeMessage constructor.
     * @param AMQPStreamConnection $queueConnection
     */
    public function __construct(AMQPStreamConnection $queueConnection, AMQPChannel $channel)
    {
        $this->connection = $queueConnection;
        $this->channel = $channel;
    }

    /**
     * @param AMQPChannel $channel
     * @param $callback
     * @return string
     */
    public function publish($message, $queueName)
    {
        $this->channel->queue_declare($queueName, false, false, true, false);
        $this->channel->basic_publish(
            $message,
            $queueName
        );
        $this->channel->close();
        $this->connection->close();
        return 'Consuming process completed';
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}