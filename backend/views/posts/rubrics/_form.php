<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\color\ColorInput;

/* @var $this yii\web\View */
/* @var $model \news\entities\posts\rubric\Rubrics */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-body">
                <?= $form->field($model, 'status')->checkbox(['class' => 'minimal']) ?>

                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'color')->widget(ColorInput::class, [
                    'options' => ['placeholder' => \Yii::t('app', 'Select color ...')],
                ]) ?>

                <?= $form->field($model, 'sort')->textInput(['type' => 'number']) ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-default">
            <div class="box-header with-border">SEO</div>
            <div class="box-body">
                <?= $form->field($model->meta, 'title')->textInput() ?>
                <?= $form->field($model->meta, 'description')->textarea(['rows' => 2]) ?>
                <?= $form->field($model->meta, 'keywords')->textInput() ?>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
