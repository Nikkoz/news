<?php

/* @var $this yii\web\View */
/* @var $user \news\entities\user\User */

$confirmLink = \Yii::$app->urlManager->createAbsoluteUrl(['auth/signup/confirm', 'token' => $user->password_reset_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to confirm your email:

<?= $confirmLink ?>
