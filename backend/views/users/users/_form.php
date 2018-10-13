<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model \news\forms\manage\users\UserForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-info">
    <?php $form = ActiveForm::begin(); ?>

    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'status')->dropDownList($model->statusList) ?>

                <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model->photo, 'photo', ['options' => ['class' => 'col-md-5']])->widget(\kartik\file\FileInput::class, [
                    'options' => [
                        'accept' => 'image/*',
                        'multiple' => false,
                    ],
                    'pluginOptions' => [
                        'allowedFileExtensions'=>['jpg','gif','png'],
                        'showCaption' => false,
                        'showRemove' => false,
                        'showUpload' => false,
                        'browseClass' => 'btn btn-primary btn-block',
                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                        'browseLabel' =>  \Yii::t('app','Photo'),
                        'initialPreview' => [
                            $model->photo->photo ? $model->photo->photo->getPicture('users') : '',
                        ],
                        'initialPreviewConfig' => [
                            [
                                'caption' => '',
                                'url' => "/users/users/remove-photo/?id={$model->id}",
                                'key' => $model->photo->getId(),
                                'extra' => [
                                    'id' => $model->photo->getId(),
                                ]
                            ]
                        ],
                        //'initialPreviewShowDelete' => true,
                        'initialPreviewAsData'=>true,
                        'overwriteInitial'=>true,
                        'fileActionSettings' => [
                            //'showZoom' => false,
                            'showDrag' => false,
                            //'showDelete' => false,
                        ]
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lastname', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'email', ['options' => ['class' => 'col-md-6']])->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'role', ['options' => ['class' => 'col-md-6']])->widget(Select2::class, [
                'items' => $model->rolesList,
                'multiple' => false,
            ]) ?>
        </div>

        <div class="row">
            <?= $form->field($model, 'password', ['options' => ['class' => 'col-md-6']])->passwordInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password_confirm', ['options' => ['class' => 'col-md-6']])->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

