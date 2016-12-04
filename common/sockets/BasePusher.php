<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 01.12.2016
 * Time: 17:25
 */

namespace common\sockets;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampServerInterface;
use ZMQContext;

class BasePusher implements WampServerInterface
{
    protected $subscribedTopics = array();

    /**
     * @return mixed
     */

    static function sendDataToServer(array $data)
    {
        $context = new ZMQContext();
        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH, 'my_pusher');
        $socket->connect("tcp://localhost:5555");
        $data = json_encode($data);
        $socket->send($data);
    }

    public function notify($jsonDataToSend)
    {
        $entryData = json_decode($jsonDataToSend, true);

        // If the lookup topic object isn't set there is no one to publish to
        if (!array_key_exists($entryData['topic_id'], $this->subscribedTopics)) {
            return;
        }

        $topic = $this->subscribedTopics[$entryData['topic_id']];

        // re-send the data to all the clients subscribed to that category
        $topic->broadcast($entryData);

    }


    public function getSubscribedTopics()
    {
        return $this->subscribedTopics;
    }

    /**
     * @param mixed $subscribedTopics
     */
    public function addSubscribedTopics($topic)
    {
        $this->subscribedTopics[$topic->getId()] = $topic;
    }


    function onOpen(ConnectionInterface $conn)
    {
        echo "New Connection ({$conn->resourceId}) \n";
    }


    function onClose(ConnectionInterface $conn)
    {
        echo "{$conn->resourceId} disconnected \n";
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "{$e->getMessage()} ";
        $conn->close();
    }


    function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $conn->callError($id, $topic, "Yo're not allowed")->close();
    }


    function onSubscribe(ConnectionInterface $conn, $topic)
    {
        $this->addSubscribedTopics($topic);
    }


    function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onUnSubscribe() method.
    }


    function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $conn->close();
    }


}