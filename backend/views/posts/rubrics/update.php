<?php

/* @var $this yii\web\View */
/* @var $model \news\entities\posts\rubric\Rubrics */

$this->title = Yii::t('app', 'Update Rubrics: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Rubrics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>