<?php

namespace news\services\manage\posts;

use news\entities\Meta;
use news\forms\manage\posts\RubricForm;
use news\entities\posts\rubric\Rubrics;
use news\repositories\posts\RubricsRepository;

/**
 * Class RubricsManageService
 * @package news\services\manage\posts
 *
 * @property RubricsRepository $repository
 */
class RubricsManageService
{
    private $repository;

    public function __construct(RubricsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(RubricForm $form): Rubrics
    {
        $rubric = Rubrics::create(
            $form->name,
            //$form->slug,
            $form->color,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->repository->save($rubric);

        return $rubric;
    }

    public function edit($id, RubricForm $form): void
    {
        $rubric = $this->repository->get($id);

        $rubric->edit(
            $form->name,
            //$form->slug,
            $form->color,
            $form->sort,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->repository->save($rubric);
    }

    public function remove($id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}