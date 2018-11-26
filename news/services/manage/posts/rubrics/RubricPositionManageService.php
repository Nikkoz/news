<?php

namespace news\services\manage\posts\rubrics;


use news\entities\posts\rubric\templates\RubricPositions;
use news\forms\manage\posts\post\rubrics\PositionForm;
use news\repositories\posts\rubrics\RubricPositionRepository;

/**
 * Class RubricPositionManageService
 * @package news\services\manage\posts\rubrics
 *
 * @property RubricPositionRepository $repository
 */
class RubricPositionManageService
{
    private $repository;

    public function __construct(RubricPositionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(PositionForm $form): RubricPositions
    {
        $position = RubricPositions::create($form->position, $form->rubric, $form->template);

        $this->repository->save($position);

        return $position;
    }

    public function edit(int $id, PositionForm $form): void
    {
        $position = $this->repository->get($id);

        $position->edit($form->position, $form->rubric, $form->template);

        $this->repository->save($position);
    }

    public function remove(int $id): void
    {
        $position = $this->repository->get($id);
        $this->repository->remove($position);
    }
}