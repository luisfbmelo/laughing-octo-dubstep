<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            /*'dsn' => 'mysql:host=localhost;dbname=yii2advanced',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',*/
            'dsn' => 'mysql:host=localhost;dbname=toque_sta',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
];
