<?php

/* @var $this yii\web\View */
/* @var $model \news\entities\posts\rubric\templates\RubricTemplates */

$this->title = Yii::t('app', 'Update Rubric template: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Rubric templates'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>