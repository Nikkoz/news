<?php
return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'site/index',
        '<_a:login|logout>' => 'auth/<_a>',

        'users' => 'users/users',
        'profile/<id:\d+>' => 'users/profile/',
        'users/create' => 'users/users/create',
        'users/<_a:(update|delete|activate|deactivate)>/<id:\d+>' => 'users/users/<_a>',

        'roles' => 'users/roles',
        'roles/create' => 'users/roles/create',
        'roles/<_a:(update|delete|activate|deactivate)>/<id:\d+>' => 'users/roles/<_a>',

        'news' => 'posts/news/index',
        'news/index' => 'posts/news/index',
        'news/create' => 'posts/news/create',
        'news/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'posts/news/<_a>',

        'videos/<_a:(update|delete|view)>/<id:\d+>' => 'videos/<_a>',

        'rubrics' => 'posts/rubrics/index',
        'rubrics/create' => 'posts/rubrics/create',
        'rubrics/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'posts/rubrics/<_a>',

        'tags' => 'posts/tags/index',
        'tags/create' => 'posts/tags/create',
        'tags/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'posts/tags/<_a>',
    ],
];