<?php

namespace news\services\manage\posts\rubrics;


use news\entities\posts\rubric\templates\RubricTemplates;
use news\forms\manage\posts\post\rubrics\TemplatesForm;
use news\repositories\posts\rubrics\RubricTemplateRepository;

/**
 * Class RubricTemplatesManageService
 * @package news\services\manage\posts\rubrics
 *
 * @property RubricTemplateRepository $repository
 */
class RubricTemplatesManageService
{
    private $repository;

    public function __construct(RubricTemplateRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(TemplatesForm $form): RubricTemplates
    {
        $template = RubricTemplates::create(
            $form->name,
            $form->file,
            $form->count_news
        );

        $this->repository->save($template);

        return $template;
    }

    public function edit(int $id, TemplatesForm $form): void
    {
        $template = $this->repository->get($id);

        $template->edit(
            $form->name,
            $form->file,
            $form->count_news
        );

        $this->repository->save($template);
    }

    public function remove(int $id): void
    {
        $rubric = $this->repository->get($id);
        $this->repository->remove($rubric);
    }
}