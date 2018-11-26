<?php

/* @var $this \yii\web\View */
/* @var $content string */

$this->beginContent('@frontend/views/layouts/main.php');?>

<?= $this->render('header_hot.php'); ?>

<?= $content;?>

<?php $this->endContent(); ?>
