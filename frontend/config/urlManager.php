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

        ['class' => 'frontend\urls\PostUrlRule'],
        ['class' => 'frontend\urls\AnalyticUrlRule'],

        'rubrics/<rubric:\w+>' => 'rubrics/index',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w-]+>' => '<_c>/<_a>',
    ],
];