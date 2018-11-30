<?php

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/inner.php');

echo $this->render('header.php', [
    'class' => ''
]);

echo $content;

$this->endContent();