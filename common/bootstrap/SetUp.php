<?php

namespace common\bootstrap;

use news\dispatchers\DeferredEventDispatcher;
use news\dispatchers\EventDispatcher;
use news\dispatchers\SimpleEventDispatcher;
use news\jobs\AsyncEventJobHandler;
use news\listeners\UserCreateRequestedListener;
use news\entities\user\events\UserCreateRequested;
use news\services\auth\PasswordResetService;
use news\services\contact\ContactService;
use news\dispatchers\AsyncEventDispatcher;
use yii\base\BootstrapInterface;
use yii\di\Container;
use yii\di\Instance;
use yii\mail\MailerInterface;
use yii\queue\Queue;
use yii\rbac\ManagerInterface;

class SetUp implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $container = \Yii::$container;

        $container->setSingleton(PasswordResetService::class, [], [
            [\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot']
        ]);

        $container->setSingleton(Queue::class, function () use ($app) {
            return $app->get('queue');
        });

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
            return new DeferredEventDispatcher(new AsyncEventDispatcher($container->get(Queue::class)));
        });

        $container->setSingleton(SimpleEventDispatcher::class, function (Container $container) {
            return new SimpleEventDispatcher($container, [
                UserCreateRequested::class => [UserCreateRequestedListener::class]
            ]);
        });

        $container->setSingleton(AsyncEventJobHandler::class, [], [
            Instance::of(SimpleEventDispatcher::class)
        ]);

        /*$container->setSingleton(DeferredEventDispatcher::class, function (Container $container) {
            return new DeferredEventDispatcher(new SimpleEventDispatcher($container, [
                UserCreateRequested::class => [UserCreateRequestedListener::class]
            ]));
        });*/
    }
}