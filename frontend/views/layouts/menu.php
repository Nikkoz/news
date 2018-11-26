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
    'options' => ['class' => 'header__navigation mainnavigation'],
    'items' => $items
]);