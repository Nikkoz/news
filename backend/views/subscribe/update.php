<?php

/* @var $this yii\web\View */
/* @var $model \news\entities\Subscribe */

$this->title = Yii::t('app', 'Update Subscribe');
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app', 'Subscribe'), 'url' => ['index']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'Update');
?>
<div class="row">
    <div class="col-md-12">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>