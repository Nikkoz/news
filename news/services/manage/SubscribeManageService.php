<?php

namespace news\services\manage;


use news\entities\Subscribe;
use news\forms\manage\SubscribeForm;
use news\repositories\SubscribeRepository;

/**
 * Class SubscribeManageService
 * @package news\services\manage
 *
 * @property SubscribeRepository $repository
 */
class SubscribeManageService
{
    private $repository;

    public function __construct(SubscribeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param SubscribeForm|\news\forms\SubscribeForm $form
     * @return Subscribe
     */
    public function create($form): Subscribe
    {
        $subscribe = Subscribe::create($form->email);

        $this->repository->save($subscribe);

        return $subscribe;
    }

    public function edit(int $id, SubscribeForm $form): void
    {
        $subscribe = $this->repository->get($id);

        $subscribe->edit($form->email);
        $this->repository->save($subscribe);
    }

    public function remove(int $id): void
    {
        $subscribe = $this->repository->get($id);

        $this->repository->remove($subscribe);
    }
}