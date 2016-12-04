<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 29.11.2016
 * Time: 19:07
 */

namespace console\controllers;


use common\sockets\Pusher;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use common\sockets\Chat; //не забудьте поменять, если отличается
use ZMQ;


class SocketController extends  \yii\console\Controller
{
    public function actionStartSocket($port = 8080)
    {

        $loop   = \React\EventLoop\Factory::create();
        $pusher = new Pusher();

        // Listen for the web server to make a ZeroMQ push after an ajax request
        $context = new \React\ZMQ\Context($loop);
        $pull = $context->getSocket(ZMQ::SOCKET_PULL);
        $pull->bind('tcp://127.0.0.1:5555'); // Binding to 127.0.0.1 means the only client that can connect is itself
        $pull->on('message', array($pusher, 'notify'));

        // Set up our WebSocket server for clients wanting real-time updates
        $webSock = new \React\Socket\Server($loop);
        $webSock->listen(8080, '0.0.0.0'); // Binding to 0.0.0.0 means remotes can connect
        $webServer = new \Ratchet\Server\IoServer(
            new \Ratchet\Http\HttpServer(
                new \Ratchet\WebSocket\WsServer(
                    new \Ratchet\Wamp\WampServer(
                        $pusher
                    )
                )
            ),
            $webSock
        );
        echo "Started";

        $loop->run();
    }
}