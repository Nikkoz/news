<?php
/* @var \news\forms\manage\posts\post\VideosForm $model */
/* @var integer $number */

use kartik\file\FileInput;
use yii\helpers\Html;
?>
<div class="row video__block">
    <div class="col-md-8">
        <div class="form-group field-videosform-<?= $number;?>-name">
            <?= Html::label(\Yii::t('app', 'Link'), "videosform-{$number}-link", [
                'class' => 'control-label'
            ]) ?>

            <?= Html::textInput("VideosForm[{$number}][link]", '', [
                'id' => "videosform-{$number}-link",
                'class' => 'form-control',
                'maxlength' => 255,
                'data-input-link' => ''
            ])?>
        </div>

        <div class="form-group field-videosform-<?= $number;?>-name">
            <?= Html::label(\Yii::t('app', 'Name'), "videosform-{$number}-name", [
                'class' => 'control-label'
            ]) ?>

            <?= Html::textInput("VideosForm[{$number}][name]", '', [
                'id' => "videosform-{$number}-name",
                'class' => 'form-control',
                'maxlength' => 255,
                'data-input-name' => ''
            ])?>
        </div>

        <div class="form-group field-videosform-<?= $number;?>-site">
            <?= Html::label(\Yii::t('app', 'Site'), "videosform-{$number}-site", [
                'class' => 'control-label'
            ]) ?>

            <?= Html::textInput("VideosForm[{$number}][site]", '', [
                'id' => "videosform-{$number}-site",
                'class' => 'form-control',
                'maxlength' => 255,
                'data-input-site' => ''
            ])?>
        </div>
    </div>
    <div class="col-md-4">
        <?= Html::label(\Yii::t('app', 'Picture'), "videosform-{$number}-picture", [
            'class' => 'control-label'
        ]) ?>

        <?= FileInput::widget([
            'model' => $model,
            'attribute' => "[{$number}]picture",
            'options' => [
                'accept' => 'image/*',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowedFileExtensions'=>['jpg','gif','png'],
                'showCaption' => false,
                'showRemove' => false,
                'showUpload' => false,
                'browseClass' => 'btn btn-primary btn-block',
                'browseIcon' => '<i class="glyphicon glyphicon-camera"></i>',
                'browseLabel' =>  \Yii::t('app','Picture'),
                'initialPreview' => [],
                'initialPreviewConfig' => [],
                //'initialPreviewShowDelete' => true,
                'initialPreviewAsData'=>true,
                'overwriteInitial'=>true,
                'fileActionSettings' => [
                    //'showZoom' => false,
                    'showDrag' => false,
                    //'showDelete' => false,
                ]
            ]
        ])?>
    </div>
</div>
