<?php

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/main.php');?>

<?= $this->render('header.php', [
    'class' => 'header_need_trasparent-js header_transparent',
]); ?>

<?= $content;?>

<?php $this->endContent(); ?>
