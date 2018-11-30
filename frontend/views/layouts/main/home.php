<?php

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/main.php');?>

<?= $this->render('header.php', [
    'class' => ''
]); ?>

<?= $content;?>

<?php $this->endContent(); ?>
