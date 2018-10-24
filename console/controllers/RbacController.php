<?php

namespace console\controllers;


use news\repositories\UserRepository;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class RbacController
 * @package console\controllers
 *
 * @property UserRepository $repository
 */
class RbacController extends Controller
{
    private $repository;

    public function __construct(string $id, $module, UserRepository $repository, array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->repository = $repository;
    }

    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...

        // Create roles
        $admin = $auth->createRole('admin');
        $admin->description = 'Администратор';

        $author = $auth->createRole('author');
        $author->description = 'Автор';

        $editor = $auth->createRole('editor');
        $editor->description = 'Редактор';

        // save roles to DB
        $auth->add($admin);
        $auth->add($author);
        $auth->add($editor);

        // Create permissions
        $adminPermission = $auth->createPermission('adminPermission');
        $adminPermission->description = 'Доступ к панели администратора';

        $authorPermission = $auth->createPermission('authorPermission');
        $authorPermission->description = 'Добавление/Редактирование статей';

        // save permissions to DB
        $auth->add($adminPermission);
        $auth->add($authorPermission);

        // add inheritance
        $auth->addChild($author, $authorPermission);
        $auth->addChild($editor, $author);
        $auth->addChild($admin, $editor);
        $auth->addChild($admin, $adminPermission);

        // create admin
        try {
            $exist = $this->repository->getById(1);
            $auth->assign($admin, $exist->id);

            $this->stdout('Admin is created.' . "\n", Console::FG_GREEN);
        } catch (\DomainException $e) {
            \Yii::$app->errorHandler->logException($e);
            $this->stdout($e->getMessage() . "\n", Console::FG_RED);
        }
    }


}