<?php

/* @var $this yii\web\View */
/* @var $model \news\entities\posts\rubric\templates\RubricTemplates */

$this->title = Yii::t('app', 'Create Rubric template');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Rubric templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>