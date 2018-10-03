<?php
/* @var \news\forms\manage\posts\post\SlidersForm $model */
/* @var integer $number */

use kartik\file\FileInput;
use yii\helpers\Html;
?>
<div class="row slider__block">
    <div class="col-md-7">
        <div class="form-group field-slidersform-<?= $number;?>-name">
            <?= Html::label(\Yii::t('app', 'Name'), "slidersform-{$number}-name", [
                'class' => 'control-label'
            ]) ?>

            <?= Html::textInput("SlidersForm[{$number}][name]", '', [
                'id' => "slidersform-{$number}-name",
                'class' => 'form-control',
                'maxlength' => 255,
                'data-input-name' => ''
            ])?>
        </div>

        <div class="form-group field-slidersform-<?= $number;?>-description">
            <?= Html::label(\Yii::t('app', 'Description'), "slidersform-{$number}-description", [
                'class' => 'control-label'
            ]) ?>

            <?= Html::textInput("SlidersForm[{$number}][description]", '', [
                'id' => "slidersform-{$number}-description",
                'class' => 'form-control',
                'maxlength' => 255,
                'data-input-description' => ''
            ])?>
        </div>
    </div>
    <div class="col-md-5">
        <?= Html::label(\Yii::t('app', 'Pictures'), "slidersform-{$number}-pictures", [
            'class' => 'control-label'
        ]) ?>

        <?= FileInput::widget([
            'model' => $model,
            'attribute' => "[{$number}]pictures[]",
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
