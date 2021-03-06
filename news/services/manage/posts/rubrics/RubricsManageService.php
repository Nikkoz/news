<?php

namespace news\services\manage\posts\rubrics;

use news\entities\Meta;
use news\forms\manage\posts\RubricForm;
use news\entities\posts\rubric\Rubrics;
use news\repositories\posts\rubrics\RubricsRepository;

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
            $form->color,
            $form->sort,
            $form->status,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->repository->save($rubric);

        return $rubric;
    }

    public function edit(int $id, RubricForm $form): void
    {
        $rubric = $this->repository->get($id);

        $rubric->edit(
            $form->name,
            $form->color,
            $form->sort,
            $form->status,
            new Meta(
                $form->meta->title,
                $form->meta->description,
                $form->meta->keywords
            )
        );

        $this->repository->save($rubric);
    }

    public function activate(int $id): void
    {
        $article = $this->repository->get($id);
        $article->activate();
        $this->repository->save($article);
    }

    public function deactivate(int $id): void
    {
        $article = $this->repository->get($id);
        $article->deactivate();
        $this->repository->save($article);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}