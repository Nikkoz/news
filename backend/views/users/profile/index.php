<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \news\forms\manage\users\UserForm */

$this->title = Yii::t('app', 'Update user: {user}', [
    'user' => $model->fullName,
]);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <?php $form = ActiveForm::begin(); ?>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
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
                    <?= $form->field($model, 'password', ['options' => ['class' => 'col-md-6']])->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'password_confirm', ['options' => ['class' => 'col-md-6']])->passwordInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="box-footer">
                <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success pull-right']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>