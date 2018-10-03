<?php
return [
    'id' => 'app-common',
    'name' => 'Ki-News',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache' //Включаем кеширование
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            /*'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                ],
            ],*/
        ],
        'i18n' => require __DIR__ . '/langs.php',
    ],
];
