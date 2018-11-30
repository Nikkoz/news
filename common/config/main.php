<?php
return [
    'id' => 'app-common',
    'name' => 'Известия',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'timeZone' => 'Europe/Moscow',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache' //Включаем кеширование
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'useMemcached' => true,
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    ],
            ],
        ],
        'queue' => [
            'class' => 'yii\queue\redis\Queue',
            'redis' => 'redis',
            'as log' => 'yii\queue\LogBehavior',
        ],
        'i18n' => require __DIR__ . '/langs.php',
    ],
];
