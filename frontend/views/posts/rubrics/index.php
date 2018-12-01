<?php

/* @var $this yii\web\View */
/* @var $rubric \news\entities\posts\rubric\Rubrics */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $template \news\entities\posts\rubric\templates\RubricTemplates */

$this->title = $rubric->name;

if (!empty($dataProvider->getTotalCount())):
    echo $this->render("templates/_{$template->file}",[
        'dataProvider' => $dataProvider,
        'rubric' => $rubric,
    ]);
else: ?>
    <div class="center">
        <p>В рубрике "<?= $rubric->name;?>" еще нет новостей.</p>
    </div>
<?php endif;?>