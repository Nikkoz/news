<?php

/* @var $this yii\web\View */
/* @var $rubric \news\entities\posts\rubric\Rubrics */
/* @var $dataProvider \yii\data\DataProviderInterface */
/* @var $template string */

$this->title = $rubric->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $rubric->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $rubric->meta->keywords]);

if (!empty($dataProvider->getTotalCount())):
    echo $this->render("templates/_{$template}", [
        'dataProvider' => $dataProvider,
        'rubric' => $rubric,
    ]);
else: ?>
    <div class="center">
        <p>В рубрике "<?= $rubric->name;?>" еще нет новостей.</p>
    </div>
<?php endif;?>