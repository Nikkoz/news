<?php
use yii\helpers\Url;
use yii\widgets\Menu;

$items[] = [
    'label' => \Yii::t('app', 'News'),
    'url' => Url::toRoute(['rubrics/index', 'rubric' => 'news'])
];

foreach ($this->params['rubrics'] as $rubric) {
    $items[] = [
        'label' => $rubric->name,
        'url' => Url::toRoute(['rubrics/index', 'rubric' => $rubric->slug]),
    ];
}

echo Menu::widget([
    'options' => ['class' => 'menu__list'],
    'items' => $items
]);

echo Menu::widget([
    'options' => ['class' => 'footer__submenu mainnavigation'],
    'items' => [
        [
            'label' => \Yii::t('app', 'About'),
            'url' => Url::toRoute(['site/about']),
        ], [
            'label' => \Yii::t('app', 'Offer cooperation'),
            'url' => Url::toRoute(['site/cooperation']),
        ], [
            'label' => \Yii::t('app', 'Suggest News'),
            'url' => Url::toRoute(['site/suggest']),
        ],
    ]
]);