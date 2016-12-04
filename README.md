# Restaurant realtime app powered by Yii2/Ratchet




### Installation

App requires  [ZeroMq](http://zeromq.org/) extension for php to run
[Instructions to install zmq](http://superuser.com/questions/585291/installing-zeromq-on-windows-7-wamp-server#answer-774973)


Create database "yii2advanced" or change params in common\config\main-local.php
Change your dir. to root of project & install all migrations

```sh
$ composer install
$ yii init
$ yii migrate
$ yii migrate --migrationPath=@yii/rbac/migrations/
$ yii rbac/init
$ yii socket/start-socket
```


