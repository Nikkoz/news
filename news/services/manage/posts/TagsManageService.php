<?php

namespace news\services\manage\posts;


use news\entities\posts\tags\Tags;
use news\forms\manage\posts\TagForm;
use news\repositories\posts\TagsRepository;

/**
 * Class TagsManageService
 * @package news\services\manage\posts
 *
 * @property TagsRepository $repository
 */
class TagsManageService
{
    private $repository;

    public function __construct(TagsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TagForm $form): Tags
    {
        $tag = Tags::create($form->name);

        $this->repository->save($tag);

        return $tag;
    }

    public function edit(int $id, TagForm $form): void
    {
        $tag = $this->repository->get($id);

        $tag->edit($form->name);

        $this->repository->save($tag);
    }

    public function remove(int $id): void
    {
        $tag = $this->repository->get($id);
        $this->repository->remove($tag);
    }
}