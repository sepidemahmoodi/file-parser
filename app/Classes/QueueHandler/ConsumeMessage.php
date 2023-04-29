<?php
namespace App\Classes\QueueHandler;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeMessage
{
    private $connection;

    /**
     * ConsumeMessage constructor.
     * @param AMQPStreamConnection $queueConnection
     */
    public function __construct(AMQPStreamConnection $queueConnection)
    {
        $this->connection = $queueConnection;
    }

    /**
     * @param AMQPChannel $channel
     * @param $callback
     * @return string
     */
    public function consume(AMQPChannel $channel, $callback, $queueName)
    {
        $channel->basic_consume(
            $queueName,
            '',
            false,
            true,
            false,
            false,
            $callback
        );
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        return 'Consuming process completed';
    }

    public function __destruct()
    {
        $this->connection->close();
    }
}