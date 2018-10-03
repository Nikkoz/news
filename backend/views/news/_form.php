<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use kartik\file\FileInput;
use backend\widgets\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\posts\News */
/* @var $form yii\widgets\ActiveForm */

$hiddens = '';
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'create__post'
    ]
]); ?>

<div class="row">
    <div class="col-md-2">
        <div class="box box-solid box-success">
            <ul class="nav nav-tabs nav-tabs-news" role="tablist">
                <li class="nav-item active">
                    <?= Html::a(\Yii::t('app', 'News'), ['#news'], [
                        'class' => 'nav-link',
                        'id' => 'news-tab',
                        'data-toggle' => 'tab',
                        'role' => 'tab',
                        'aria-controls' => 'news',
                        'aria-selected' => true,
                    ]);?>
                </li>
                <li class="nav-item">
                    <?= Html::a(\Yii::t('app', 'Sliders'), ['#sliders'], [
                        'class' => 'nav-link',
                        'id' => 'sliders-tab',
                        'data-toggle' => 'tab',
                        'role' => 'tab',
                        'aria-controls' => 'sliders',
                        'aria-selected' => false,
                    ]);?>
                </li>
                <li class="nav-item">
                    <?= Html::a(\Yii::t('app', 'Videos'), ['#videos'], [
                        'class' => 'nav-link',
                        'id' => 'videos-tab',
                        'data-toggle' => 'tab',
                        'role' => 'tab',
                        'aria-controls' => 'videos',
                        'aria-selected' => false,
                    ]);?>
                </li>
                <li class="nav-item">
                    <?= Html::a(\Yii::t('app', 'Rubrics'), ['#rubrics'], [
                        'class' => 'nav-link',
                        'id' => 'rubrics-tab',
                        'data-toggle' => 'tab',
                        'role' => 'tab',
                        'aria-controls' => 'rubrics',
                        'aria-selected' => false,
                    ]);?>
                </li>
                <li class="nav-item">
                    <?= Html::a(\Yii::t('app', 'Text'), ['#text'], [
                        'class' => 'nav-link',
                        'id' => 'text-tab',
                        'data-toggle' => 'tab',
                        'role' => 'tab',
                        'aria-controls' => 'text',
                        'aria-selected' => false,
                    ]);?>
                </li>
            </ul>
        </div>
        <div class="form-group btns-block">
            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'name' => 'save']) ?>

            <?= Html::submitButton(\Yii::t('app', 'Apply'), ['class' => 'btn btn-default', 'name' => 'apply']) ?>

            <?= Html::a(\Yii::t('app', 'Cancel'), ['news/index'], ['class' => 'btn btn-default']); ?>
        </div>
    </div>
    <div class="col-md-10">
        <?php if($model->sliders) {
            foreach ($model->sliders as $slider) {
                echo $form->field($model, 'sliders[]', ['options' => ['class' => 'hide']])->hiddenInput(['value' => $slider->id]);
            }
        } ?>

        <?php if($model->videos) {
            foreach ($model->videos as $video) {
                echo $form->field($model, 'videos[]', ['options' => ['class' => 'hide']])->hiddenInput(['value' => $video->id]);
            }
        } ?>

        <div class="tab-content">
            <div class="tab-pane active" id="news" role="tabpanel" aria-labelledby="news-tab">
                <div class="box box-solid box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-10">
                                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-2">
                                <?= $form->field($model, 'sort')->textInput(['type' => 'number', 'value' => $model->sort ?: 100]) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <?= $form->field($model, 'preview_text')->widget(Widget::className(), [
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
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <?= $form->field($model, 'is_analytic')->checkbox(['class' => 'minimal', 'data-image-toggle' => 'analytic_picture']) ?>
                            </div>
                            <div class="col-md-3">
                                <?= $form->field($model, 'hot')->checkbox(['class' => 'minimal', 'data-image-toggle' => 'hot_picture']) ?>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'rectanglePictureFile')->widget(FileInput::className(), [
                                    'options' => ['accept' => 'image/*','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowedFileExtensions'=>['jpg','gif','png'],
                                        'showCaption' => false,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                        'browseLabel' =>  \Yii::t('app','Picture'),
                                        'initialPreview' => [
                                            $model->rectanglePictureFile ? $model->getRectanglePictureFile()->one()->getPicture('posts') : '',
                                        ],
                                        'initialPreviewConfig' => [
                                            [
                                                'caption' => '',
                                                'url' => "/pictures/delete/{$model->rectangle_picture}",
                                                'key' => $model->rectangle_picture,
                                                'extra' => [
                                                    'id' => $model->rectangle_picture,
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
                            <div class="col-md-4">
                                <?= $form->field($model, 'squarePictureFile')->widget(FileInput::className(), [
                                    'options' => ['accept' => 'image/*','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowedFileExtensions'=>['jpg','gif','png'],
                                        'showCaption' => false,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                        'browseLabel' =>  \Yii::t('app','Picture'),
                                        'initialPreview' => [
                                            $model->squarePictureFile ? $model->getSquarePictureFile()->one()->getPicture('posts') : '',
                                        ],
                                        'initialPreviewConfig' => [
                                            [
                                                'caption' => '',
                                                'url' => "/pictures/delete/{$model->square_picture}",
                                                'key' => $model->square_picture,
                                                'extra' => [
                                                    'id' => $model->square_picture,
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
                            <div class="col-md-4">
                                <?= $form->field($model, 'hotPictureFile', ['options' => ['class' => $model->hot ? '' : 'hide', 'id' => 'hot_picture']])->widget(FileInput::className(), [
                                    'options' => ['accept' => 'image/*','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowedFileExtensions'=>['jpg','gif','png'],
                                        'showCaption' => false,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                        'browseLabel' =>  \Yii::t('app','Picture'),
                                        'initialPreview' => [
                                            $model->hotPictureFile ? $model->getHotPictureFile()->one()->getPicture('posts') : '',
                                        ],
                                        'initialPreviewConfig' => [
                                            [
                                                'caption' => '',
                                                'url' => "/pictures/delete/{$model->hot_picture}",
                                                'key' => $model->hot_picture,
                                                'extra' => [
                                                    'id' => $model->hot_picture,
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

                                <?= $form->field($model, 'analyticPictureFile', ['options' => ['class' => $model->is_analytic ? '' : 'hide', 'id' => 'analytic_picture']])->widget(FileInput::className(), [
                                    'options' => ['accept' => 'image/*','multiple'=>false],
                                    'pluginOptions' => [
                                        'allowedFileExtensions'=>['jpg','gif','png'],
                                        'showCaption' => false,
                                        'showRemove' => false,
                                        'showUpload' => false,
                                        'browseClass' => 'btn btn-primary btn-block',
                                        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
                                        'browseLabel' =>  \Yii::t('app','Picture'),
                                        'initialPreview' => [
                                            $model->analyticPictureFile ? $model->getAnalyticPictureFile()->one()->getPicture('posts') : '',
                                        ],
                                        'initialPreviewConfig' => [
                                            [
                                                'caption' => '',
                                                'url' => "/pictures/delete/{$model->analytic_picture}",
                                                'key' => $model->analytic_picture,
                                                'extra' => [
                                                    'id' => $model->analytic_picture,
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
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="sliders" role="tabpanel" aria-labelledby="sliders-tab">
                <div class="box box-solid box-primary">
                    <div class="box-body" id="sliderList">
                        <?php if(!empty($model->sliders)) :
                            foreach ($model->sliders as $slider) : ?>
                                <div class="slider__block" data-slider-id="<?= $slider->id; ?>">
                                    <div class="name"><b><?= \Yii::t('app', 'Name'); ?></b>: <?= $slider->name; ?></div>
                                    <div class="description"><b><?= \Yii::t('app', 'Description'); ?></b>: <?= $slider->description; ?></div>
                                    <div class="row">
                                        <?php foreach ($slider->pictures as $picture) : ?>
                                            <div class="col-md-4">
                                                <?= Html::img($picture->getPicture('posts'), ['class' => 'img']);?>
                                            </div>
                                        <?php endforeach;?>
                                    </div>
                                    <div class="btns__block-slider" data-type="slider">
                                        <?= Html::a(\Yii::t('app', 'Delete'), ['/sliders/delete', 'id' => $slider->id], ['class' => 'btn btn-danger', 'rel' => 'delete']) ?>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <div class="box-footer">
                        <?= Html::button(
                            \Yii::t('app', 'Create slider'),
                            [
                                'class' => 'btn btn-success news-add_slider',
                                'data-toggle' => 'modal',
                                'data-target' => '#sliderCreate'
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="videos" role="tabpanel" aria-labelledby="videos-tab">
                <div class="box box-solid box-primary">
                    <div class="box-body" id="videoList">
                        <?php if(!empty($model->videos)) :
                            foreach ($model->videos as $video) : ?>
                                <div class="slider__block" data-video-id="<?= $video->id; ?>">
                                    <div class="name"><b><?= \Yii::t('app', 'Name'); ?></b>: <?= $video->name; ?></div>
                                    <div class="description"><b><?= \Yii::t('app', 'Link'); ?></b>: <?= $video->link; ?></div>
                                    <div class="description"><b><?= \Yii::t('app', 'Site'); ?></b>: <?= $video->site; ?></div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <?= Html::img($video->pictures->getPicture('posts'), ['class' => 'img']);?>
                                        </div>
                                    </div>
                                    <div class="btns__block-slider" data-type="video">
                                        <?= Html::a(\Yii::t('app', 'Delete'), ['/videos/delete', 'id' => $video->id], ['class' => 'btn btn-danger', 'rel' => 'delete']) ?>
                                    </div>
                                </div>
                            <?php endforeach;
                        endif; ?>
                    </div>
                    <div class="box-footer">
                        <?= Html::button(
                            \Yii::t('app', 'Create video'),
                            [
                                'class' => 'btn btn-success news-add_slider',
                                'data-toggle' => 'modal',
                                'data-target' => '#videoCreate'
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="rubrics" role="tabpanel" aria-labelledby="rubrics-tab">
                <div class="box box-solid box-primary">
                    <div class="box-body">
                        <?= $form->field($model, 'rubrics')->widget(Select2::className(), [
                            'items' => ArrayHelper::map($model->getRubricsList()->all(), 'id', 'name'),
                            'multiple' => true
                        ]) ?>

                        <?= $form->field($model, 'discussing')->checkbox(['class' => 'minimal']) ?>

                        <?= $form->field($model, 'reading')->checkbox(['class' => 'minimal']) ?>

                        <?= $form->field($model, 'choice')->checkbox(['class' => 'minimal']) ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="text" role="tabpanel" aria-labelledby="text-tab">
                <?php //= $form->field($model, 'detail_text')->hiddenInput()->label(false); ?>

                <div class="box box-solid box-primary">
                    <a href="#" class="btn" rel="text">Текст</a>
                    <a href="#" class="btn" rel="slider">Фотогалерея</a>
                    <a href="#" class="btn" rel="video">Видео</a>
                    <a href="#" class="btn" rel="tizer">Тизер</a>
                </div>
                <div class="box box-solid box-primary">
                    <div class="box-body" id="text_constructor">
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

                <?= $hiddens;?>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

<div class="modal fade" tabindex="-1" role="dialog" id="sliderCreate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавление слайдера</h4>
            </div>
            <div class="content">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="videoCreate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Добавление видеоролика</h4>
            </div>
            <div class="content">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="sliderUpdate">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Обновление слайдера</h4>
            </div>
            <div class="content">

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

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

<div class="modal fade" tabindex="-1" role="dialog" id="tizerSelect" data-news="<?= $model->id;?>">
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