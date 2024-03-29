<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=kursogramma_db;dbname=kursogramma_db',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'ishop_db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=kursogramma_db;dbname=ishop',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
