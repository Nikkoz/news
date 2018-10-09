<?php
return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['backendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'news' => 'posts/news/index',
        'news/index' => 'posts/news/index',
        'news/create' => 'posts/news/create',
        'news/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'posts/news/<_a>',

        'videos/<_a:(update|delete|view)>/<id:\d+>' => 'videos/<_a>',

        'rubrics' => 'posts/rubrics/index',
        'rubrics/create' => 'posts/rubrics/create',
        'rubrics/<_a:(update|delete|view|activate|deactivate)>/<id:\d+>' => 'posts/rubrics/<_a>',
    ],
];