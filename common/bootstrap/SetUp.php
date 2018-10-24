<?php

namespace common\bootstrap;

use news\dispatchers\DeferredEventDispatcher;
use news\dispatchers\EventDispatcher;
use news\dispatchers\SimpleEventDispatcher;
use news\listeners\UserCreateRequestedListener;
use news\entities\user\events\UserCreateRequested;
use news\services\auth\PasswordResetService;
use news\services\contact\ContactService;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\mail\MailerInterface;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']
        ]);

        $container->setSingleton(MailerInterface::class, function () use ($app) {
            return $app->mailer;
        });

        $container->setSingleton(ContactService::class, [], [
            $app->params['supportEmail'],
            $app->params['adminEmail'],
            //Instance::of(MailerInterface::class)
        ]);

        $container->setSingleton(ManagerInterface::class, function () use ($app) {
            return $app->authManager;
        });

        $container->setSingleton(EventDispatcher::class, DeferredEventDispatcher::class);

        $container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new SimpleEventDispatcher($container, [
                UserCreateRequested::class => [UserCreateRequestedListener::class]
            ]));
        });
    }
}