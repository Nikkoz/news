<?php
return [
    'class' => 'yii\web\UrlManager',
    'baseUrl' => '',
    'hostInfo' => $params['frontendHostInfo'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        '' => 'main/index',

        '<_a:about>' => 'site/<_a>',
        '<_c:cooperation>' => 'site/<_c>',
        '<_s:suggest>' => 'site/<_s>',
        'contact' => 'contact/index',
        'signup' => 'auth/signup/request',
        'signup/<_a:[/w-]+>' => 'auth/signup/<_a>',
        '<_a:login|logout>' => 'auth/auth/<_a>',

        'tag/<tag:\w+>' => 'posts/post/tag',

        'rubrics/<rubric:\w+>' => 'posts/rubrics/index',
        ['class' => 'frontend\urls\AnalyticUrlRule'],
        ['class' => 'frontend\urls\PostUrlRule'],

        '/authors' => 'posts/authors/index',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];