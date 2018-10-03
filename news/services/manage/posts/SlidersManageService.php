<?php
namespace news\services\manage\posts;

use news\entities\Pictures;
use news\entities\posts\slider\PicturesSliderAssignments;
use news\entities\posts\slider\Sliders;
use news\forms\manage\posts\post\SlidersForm;
use news\repositories\PicturesRepository;
use news\repositories\posts\SlidersRepository;
use news\services\TransactionManager;

/**
 * Class SlidersManageService
 * @package news\services\manage\posts
 *
 * @property SlidersRepository $repository
 * @property PicturesRepository $pictureRepository
 *
 * @property TransactionManager $transaction
 */
class SlidersManageService
{
    private $repository;
    private $pictureRepository;
    private $transaction;

    public function __construct(SlidersRepository $repository, PicturesRepository $pictureRepository, TransactionManager $transaction)
    {
        $this->repository = $repository;
        $this->pictureRepository = $pictureRepository;
        $this->transaction = $transaction;
    }

    public function create(SlidersForm $form): Sliders
    {
        $slider = Sliders::create($form->name, $form->description);

        $this->transaction->wrap(function () use ($slider, $form) {
            foreach ($form->pictures as $picture) {

                $file = $this->pictureRepository->saveFile($picture);

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $slider->assignPicture($picture->id);
            }

            $this->repository->save($slider);
        });

        return $slider;
    }

    public function edit(int $id, SlidersForm $form): void
    {
        $slider = $this->repository->get($id);

        $slider->edit($form->name, $form->description);

        $this->transaction->wrap(function () use ($slider, $form) {
            foreach ($form->pictures as $picture) {

                $file = $this->pictureRepository->saveFile($picture);

                $picture = Pictures::create($file);
                $this->pictureRepository->save($picture);

                $slider->assignPicture($picture->id);
            }

            $this->repository->save($slider);
        });
    }

    public function remove($id): void
    {
        $slider = $this->repository->get($id);
        $this->repository->remove($slider);
    }

    public function removePicture(int $sliderId, int $pictureId): void
    {
        $slider = $this->repository->get($sliderId);
        $picture = $this->pictureRepository->get($pictureId);

        $slider->revokePicture($pictureId);
        $this->pictureRepository->remove($picture);
    }
}