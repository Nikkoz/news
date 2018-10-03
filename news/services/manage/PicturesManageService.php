<?php

namespace news\services\manage;


use news\repositories\PicturesRepository;

/**
 * Class PicturesManageService
 * @package news\services\manage
 *
 * @property PicturesRepository $repository
 */
class PicturesManageService
{
    private $repository;

    public function __construct(PicturesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function remove($id): void
    {
        $picture = $this->repository->get($id);
        $this->repository->remove($picture);
    }
}