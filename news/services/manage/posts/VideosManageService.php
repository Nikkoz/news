<?php
namespace news\services\manage\posts;

use news\entities\Pictures;
use news\entities\posts\video\Videos;
use news\forms\manage\posts\post\VideosForm;
use news\repositories\PicturesRepository;
use news\repositories\posts\VideosRepository;
use news\services\TransactionManager;

/**
 * Class VideosManageService
 * @package news\services\manage\posts
 *
 * @property VideosRepository $repository
 * @property PicturesRepository $pictureRepository
 *
 * @property TransactionManager $transaction
 */
class VideosManageService
{
    private $repository;
    private $pictureRepository;
    private $transaction;

    public function __construct(VideosRepository $repository, PicturesRepository $pictureRepository, TransactionManager $transaction)
    {
        $this->repository = $repository;
        $this->pictureRepository = $pictureRepository;
        $this->transaction = $transaction;
    }

    public function create(VideosForm $form): Videos
    {
        $video = Videos::create($form->link, $form->name, $form->site);

        $this->transaction->wrap(function() use ($video, $form) {
            if($form->picture) {
                $file = $this->pictureRepository->saveFile($form->picture);

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $video->setPicture($picture->id);
            }

            $this->repository->save($video);
        });

        return $video;
    }

    public function edit(int $id, VideosForm $form): void
    {
        $video = $this->repository->get($id);

        $video->edit($form->link, $form->name, $form->site);

        $this->transaction->wrap(function() use ($video, $form) {
            if($form->picture) {
                $file = $this->pictureRepository->saveFile($form->picture);

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $video->setPicture($picture->id);
            }

            $this->repository->save($video);
        });
    }

    public function remove($id): void
    {
        $video = $this->repository->get($id);
        $this->repository->remove($video);
    }
}