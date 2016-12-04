<?php
/**
 * Created by PhpStorm.
 * User: Yurii
 * Date: 01.12.2016
 * Time: 18:09
 */

namespace common\sockets;

use ZMQContext;

class Pusher extends BasePusher
{

    const TOPIC_NEW_ORDER = 'newOrder';
    const TOPIC_STATUS_CHANGED = 'statusChange';


}