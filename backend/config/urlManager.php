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
        'news/<_a:(update|delete|view)>/<id:\d+>' => 'posts/news/<_a>',

        'videos/<_a:(update|delete|view)>/<id:\d+>' => 'videos/<_a>',
        'rubrics' => 'posts/rubrics/index',
        'rubrics/create' => 'posts/rubrics/create',
        'test' => 'posts/test/index',
        'rubrics/<_a:(update|delete|view)>/<id:\d+>' => 'posts/rubrics/<_a>',
        //'pictures/<_a:(delete)>/<id:\d+>' => 'pictures/<_a>',

        /*'' => 'site/index',
        '<_a:login|logout>' => 'site/<_a>',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',*/
    ],
];