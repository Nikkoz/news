<?php

/* @var $this yii\web\View */
/* @var $model \news\entities\posts\rubric\templates\RubricPositions */

$this->title = Yii::t('app', 'Create Rubric position');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Rubric positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>