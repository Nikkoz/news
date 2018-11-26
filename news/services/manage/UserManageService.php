<?php

namespace news\services\manage;


use news\entities\Pictures;
use news\entities\user\User;
use news\forms\manage\users\UserForm;
use news\repositories\PicturesRepository;
use news\repositories\UserRepository;
use news\services\RoleManager;
use news\services\TransactionManager;

/**
 * Class UserManageService
 * @package news\services\manage
 *
 * @property UserRepository $repository
 * @property PicturesRepository $pictureRepository
 * @property RoleManager $manager
 * @property TransactionManager $transaction
 */
class UserManageService
{
    private $repository;
    private $pictureRepository;
    private $manager;
    private $transaction;

    private $folder = 'users';

    public function __construct(
        UserRepository $repository,
        PicturesRepository $pictureRepository,
        RoleManager $manager,
        TransactionManager $transaction
    )
    {
        $this->repository = $repository;
        $this->pictureRepository = $pictureRepository;
        $this->manager = $manager;
        $this->transaction = $transaction;
    }

    /**
     * @param UserForm $form
     * @return User
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function create(UserForm $form): User
    {
        $user = User::create(
            $form->username,
            $form->email,
            $form->name,
            $form->lastname,
            $form->password
        );

        if($form->role = 'author') {
            $user->requestPasswordReset();
        }

        $this->transaction->wrap(function () use ($user, $form) {
            if ($form->photo->photo) {
                $file = $this->pictureRepository->saveFile($form->photo->photo, 'users', ['64x64', '40x40']);

                $picture = Pictures::create($file, 'users');
                $this->pictureRepository->save($picture);

                $user->assignPhoto($picture->id);
            }

            $this->repository->save($user);
            $this->manager->assign($user->id, $form->role);
        });

        return $user;
    }

    /**
     * @param int $id
     * @param UserForm $form
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\Exception
     */
    public function edit(int $id, UserForm $form): void
    {
        $user = $this->repository->getById($id);
        $user->edit(
            $form->username,
            $form->email,
            $form->name,
            $form->lastname,
            $form->password
        );

        $this->transaction->wrap(function () use ($user, $form) {
            if ($form->photo->photo) {
                $file = $this->pictureRepository->saveFile($form->photo->photo, 'users', ['64x64', '40x40']);

                $picture = Pictures::create($file, 'users');
                $this->pictureRepository->save($picture);

                $this->checkPicture($picture->id, $user->photo);

                $user->assignPhoto($picture->id);
            }

            $this->repository->save($user);
            $this->manager->assign($user->id, $form->role);
        });
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove($id): void
    {
        $user = $this->repository->getById($id);
        $this->repository->remove($user);
    }

    public function activate(int $id): void
    {
        $article = $this->repository->getById($id);
        $article->activate();
        $this->repository->save($article);
    }

    public function deactivate(int $id): void
    {
        $article = $this->repository->getById($id);
        $article->deactivate();
        $this->repository->save($article);
    }

    private function checkPicture(int $newId, int $id = null): void
    {
        if ($id && $id != $newId) {
            $picture = $this->pictureRepository->get($id);
            $this->pictureRepository->remove($picture, $this->folder);
        }
    }

    public function removePicture(int $id): void
    {
        $user = $this->repository->getById($id);
        $picture = $this->pictureRepository->get($user->photo);

        $user->revokePhoto();
        $this->pictureRepository->remove($picture, $this->folder);
    }
}