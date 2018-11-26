<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \news\entities\user\User */

$resetLink = \Yii::$app->get('frontendUrlManager')->createAbsoluteUrl(['auth/reset/confirm', 'token' => $user->password_reset_token]);
?>
Hello <?= Html::encode($user->username) ?>,
Follow the link below to reset your password:

<?= $resetLink;?>
