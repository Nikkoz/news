<?php

use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use backend\widgets\Select2;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \news\forms\manage\posts\post\NewsCreateForm */

$this->title = Yii::t('app', 'Create News');
$this->params['breadcrumbs'][] = ['label' => Yii::t('posts', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin([
            'options' => [
                'enctype' => 'multipart/form-data',
                'class' => 'create__post'
            ]
        ]); ?>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#article" data-toggle="tab"><?= \Yii::t('app', 'Article');?></a></li>
                <li><a href="#rubric" data-toggle="tab"><?= \Yii::t('app', 'Rubric');?></a></li>
                <li><a href="#pictures" data-toggle="tab"><?= \Yii::t('app', 'Pictures');?></a></li>
                <li><a href="#sliders" data-toggle="tab"><?= \Yii::t('app', 'Sliders');?></a></li>
                <li><a href="#videos" data-toggle="tab"><?= \Yii::t('app', 'Videos');?></a></li>
                <li><a href="#text" data-toggle="tab"><?= \Yii::t('app', 'Text');?></a></li>
                <li><a href="#meta" data-toggle="tab"><?= \Yii::t('app', 'SEO');?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="article">
                    <?= $form->field($model, 'status')->checkbox(['class' => 'minimal']) ?>

                    <div class="row">
                        <div class="col-md-10">
                            <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-2">
                            <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'value' => $model->sort ?: 100]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <?= $form->field($model, 'analytics', ['options' => ['class' => 'col-md-2']])->checkbox(['class' => 'minimal']) ?>

                        <?= $form->field($model, 'hot', ['options' => ['class' => 'col-md-2']])->checkbox(['class' => 'minimal']) ?>
                    </div>

                    <?= $form->field($model, 'preview_text')->widget(Widget::class,[
                        'settings' => [
                            'lang' => 'ru',
                            'minHeight' => 200,
                            'maxHeight' => 300,
                            'plugins' => [
                                'clips',
                                'fullscreen',
                            ],
                        ],
                    ]) ?>
                </div>
                <div class="tab-pane" id="rubric">
                    <?= $form->field($model->rubrics, 'rubrics')->widget(Select2::class, [
                        'items' => $model->rubrics->rubricsList(),
                        'multiple' => true
                    ]) ?>

                    <div class="row">
                        <?= $form->field($model, 'discussing', ['options' => ['class' => 'col-md-2']])->checkbox(['class' => 'minimal']) ?>

                        <?= $form->field($model, 'reading', ['options' => ['class' => 'col-md-2']])->checkbox(['class' => 'minimal']) ?>

                        <?= $form->field($model,'choice', ['options' => ['class' => 'col-md-2']])->checkbox(['class' => 'minimal']) ?>
                    </div>

                </div>
                <div class="tab-pane" id="pictures">
                    <div class="row">
                        <?= $form->field($model->pictures, 'rectanglePictureFile', ['options' => ['class' => 'col-md-4']])->widget(\kartik\file\FileInput::class, [
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
                            ],
                        ]) ?>

                        <?= $form->field($model->pictures, 'squarePictureFile', ['options' => ['class' => 'col-md-4']])->widget(\kartik\file\FileInput::class, [
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
                            ],
                        ]) ?>

                        <?= $form->field($model->pictures, 'hotPictureFile', ['options' => ['class' => 'col-md-4']])->widget(\kartik\file\FileInput::class, [
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
                            ],
                        ]) ?>

                        <?= $form->field($model->pictures, 'analyticPictureFile', ['options' => ['class' => 'col-md-4']])->widget(\kartik\file\FileInput::class, [
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
                            ],
                        ]) ?>
                    </div>
                </div>
                <div class="tab-pane" id="sliders">
                    <div id="sliderContent">
                        <?php foreach ($model->sliders as $i => $slider) : ?>
                            <div class="row slider__block">
                                <div class="col-md-7">
                                    <?= $form->field($slider, "[{$i}]name")->textInput(['maxlength' => true, 'data-input-name' => '']) ?>

                                    <?= $form->field($slider, "[{$i}]description")->textInput(['maxlength' => true, 'data-input-description' => '']) ?>
                                </div>
                                <div class="col-md-5">
                                    <?= $form->field($slider, "[{$i}]pictures[]")->widget(\kartik\file\FileInput::class, [
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
                                            'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
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
                                        ],
                                    ]) ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?= Html::button(
                        \Yii::t('app', 'Add slider'),
                        [
                            'class' => 'btn btn-success news-add_slider',
                            'data-number' => count($model->sliders)
                        ]
                    ); ?>
                </div>
                <div class="tab-pane" id="videos">
                    <div id="videoContent">
                        <?php foreach ($model->videos as $i => $video) :
                            $picture = $video->video ? $video->video->getPicture()->one() : [];?>

                            <div class="row video__block">
                                <div class="col-md-8">
                                    <?= $form->field($video, "[{$i}]link")->textInput(['maxlength' => true, 'data-input-link' => '']) ?>

                                    <?= $form->field($video, "[{$i}]name")->textInput(['maxlength' => true, 'data-input-name' => '']) ?>

                                    <?= $form->field($video, "[{$i}]site")->textInput(['maxlength' => true, 'data-input-site' => '']) ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $form->field($video, "[{$i}]picture")->widget(\kartik\file\FileInput::class, [
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
                                        ],
                                    ])->label(\Yii::t('app','Picture')) ?>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    </div>
                    <?= Html::button(
                        \Yii::t('app', 'Add video'),
                        [
                            'class' => 'btn btn-success news-add_video',
                            'data-number' => count($model->videos)
                        ]
                    ); ?>
                </div>
                <div class="tab-pane" id="text">
                    <div class="box box-solid box-primary">
                        <a href="#" class="btn" rel="text">Текст</a>
                        <a href="#" class="btn" rel="slider">Фотогалерея</a>
                        <a href="#" class="btn" rel="video">Видео</a>
                        <a href="#" class="btn" rel="tizer">Тизер</a>
                    </div>

                    <div id="text_constructor">
                        <?php if(!empty($model->detail_text)) :
                            foreach ($model->detail_text as $position=>$section) :
                                if(count($section) == 1) :
                                    if(isset($section['text'])) :
                                        $hiddens .= '<input type="hidden" name="order[]" value="text_' . $position . '" />';?>

                                        <div class="text__block text" data-position="<?= $position;?>" data-type="text">
                                            <textarea name="text_<?= $position;?>" id="text-field-<?= $position;?>">
                                                <?= $section['text'];?>
                                            </textarea>
                                            <span class="remove-block">×</span>
                                        </div>
                                    <?php elseif(isset($section['slider'])) :
                                        $slider = $model->getSlider($section['slider']);
                                        $hiddens .= '<input type="hidden" name="order[]" value="slider_' . $position . '" />';?>

                                        <div class="text__block slider" data-position="<?= $position;?>" data-type="slider">
                                            Фотогалерея "<?= $slider->name;?>"
                                            <input type="hidden" name="slider_<?= $position;?>" value="<?= $slider->id;?>" />
                                            <span class="remove-block">×</span>
                                        </div>
                                    <?php elseif(isset($section['video'])) :
                                        $video = $model->getVideo($section['video']);
                                        $hiddens .= '<input type="hidden" name="order[]" value="video_' . $position . '" />';?>

                                        <div class="text__block video" data-position="<?= $position;?>" data-type="video">
                                            Видеоролик "<?= $video->name;?>"
                                            <input type="hidden" name="video_<?= $position;?>" value="<?= $video->id;?>" />
                                            <span class="remove-block">×</span>
                                        </div>
                                    <?php endif;
                                else :
                                    $tizer = $model->getTizer($section['tizer']);
                                    $hiddens .= '<input type="hidden" name="order[]" value="tizer_' . $position . '" />';?>

                                    <div class="text__block tizer" data-position="<?= $position;?>" data-type="tizer">
                                        <div class="tizer__select"  data-toggle="modal" data-target="#tizerSelect">
                                            <input type="hidden" name="tizer_<?= $position;?>" value="<?= $tizer->id;?>" />
                                            <span><?= $tizer->title;?></span>
                                        </div>
                                        <textarea name="text_<?= $position;?>" id="text-field-<?= $position;?>">
                                            <?= $section['text'];?>
                                        </textarea>
                                        <span class="remove-block">×</span>
                                    </div>
                                <?php endif;
                            endforeach;
                        endif;?>
                    </div>
                </div>
                <div class="tab-pane" id="meta">
                    <?= $form->field($model->meta, 'title')->textInput() ?>

                    <?= $form->field($model->meta, 'description')->textInput() ?>

                    <?= $form->field($model->meta, 'keywords')->textInput() ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="modal fade" tabindex="-1" role="dialog" id="sliderSelect">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Выбор слайдера</h4>
                    </div>
                    <div class="content">

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="videoSelect">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Вставка видео</h4>
                    </div>
                    <div class="content">

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" tabindex="-1" role="dialog" id="tizerSelect" data-news="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Выберите тизер</h4>
                    </div>
                    <div class="content">

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>