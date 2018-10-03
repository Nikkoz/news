<?php

namespace common\bootstrap;

use news\services\auth\SignupService;
use news\services\contact\ContactService;
use yii\base\BootstrapInterface;
use news\services\auth\PasswordResetService;
use yii\di\Instance;
use yii\mail\MailerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']
        ]);

        $container->setSingleton(SignupService::class);

        $container->setSingleton(MailerInterface::class, function() use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ContactService::class, [], [
            $app->params['supportEmail'],
            $app->params['adminEmail'],
            //Instance::of(MailerInterface::class)
        ]);

        /*$container->setSingleton(PasswordResetService::class, function() use ($app) {
            return new PasswordResetService([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']);
        });*/
    }
}