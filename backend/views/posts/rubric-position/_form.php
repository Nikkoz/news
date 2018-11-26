<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\Select2;
use news\helpers\rubrics\RubricsHelper;

/* @var $this yii\web\View */
/* @var $model \news\forms\manage\posts\post\rubrics\PositionForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-body">
                <div class="row">
                    <?= $form->field($model, 'template', ['options' => ['class' => 'col-md-4']])->widget(Select2::class, [
                        'items' => $model->templates
                    ]) ?>

                    <?= $form->field($model, 'rubric', ['options' => ['class' => 'col-md-4']])->widget(Select2::class, [
                        'items' => $model->rubrics
                    ]) ?>

                    <?= $form->field($model, 'position', ['options' => ['class' => 'col-md-4']])->widget(Select2::class, [
                        'items' => RubricsHelper::positionsList()
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
