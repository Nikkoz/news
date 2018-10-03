<?php

use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \news\forms\manage\posts\post\NewsCreateForm */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'create__post'
    ]
]); ?>

    <?= $form->field($model, 'title')->textInput() ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model->rubrics, 'rubrics')->dropDownList($model->rubrics->rubricsList(), ['multiple'=>'multiple']) ?>

    <?= $form->field($model, 'preview_text')->textarea() ?>

    <?= $form->field($model, 'detail_text')->textarea() ?>

    <?= $form->field($model, 'analytics')->checkbox() ?>

    <?= $form->field($model, 'hot')->checkbox() ?>

    <?= $form->field($model, 'discussing')->checkbox() ?>

    <?= $form->field($model, 'reading')->checkbox() ?>

    <?= $form->field($model,'choice')->checkbox() ?>

    <?= $form->field($model, 'status')->checkbox() ?>

    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model->pictures, 'rectanglePictureFile')->widget(\kartik\file\FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ]
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model->pictures, 'squarePictureFile')->widget(\kartik\file\FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ]
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model->pictures, 'hotPictureFile')->widget(\kartik\file\FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ]
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model->pictures, 'analyticPictureFile')->widget(\kartik\file\FileInput::class, [
                'options' => [
                    'accept' => 'image/*',
                    'multiple' => false,
                ]
            ]) ?>
        </div>
    </div>

    <?php foreach ($model->sliders as $i => $slider) : ?>

        <div class="box box-default">
            <div class="box-header with-border">Слайдер</div>
            <div class="box-body">
                <?= $form->field($slider, "[{$i}]name")->textInput() ?>

                <?= $form->field($slider, "[{$i}]description")->textInput() ?>

                <?= $form->field($slider, "pictures[]")->widget(\kartik\file\FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => true,
                    ]
                ]) ?>
            </div>
        </div>

    <?php endforeach; ?>

    <?php foreach ($model->videos as $i => $video) : ?>

        <div class="box box-default">
            <div class="box-header with-border">Видео</div>
            <div class="box-body">
                <?= $form->field($video, "[{$i}]link")->textInput() ?>

                <?= $form->field($video, "[{$i}]name")->textInput() ?>

                <?= $form->field($video, "[{$i}]site")->textInput() ?>

                <?= $form->field($video, "picture")->widget(\kartik\file\FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ]
                ]) ?>
            </div>
        </div>

    <?php endforeach; ?>

    <?= $form->field($model->meta, 'title')->textInput() ?>

    <?= $form->field($model->meta, 'description')->textInput() ?>

    <?= $form->field($model->meta, 'keywords')->textInput() ?>

    <div class="form-group">
        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>