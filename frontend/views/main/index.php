<?php

/* @var $this yii\web\View */
/* @var $hot \news\entities\posts\News */
/* @var $news \news\entities\posts\News[] */
/* @var $rubrics array */
/* @var $reading array */
/* @var $discussing array */
/* @var $choice array */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\StringHelper;
use news\entities\posts\News;
use news\helpers\NewsHelper;

$this->title = \Yii::$app->name;

if ($hot): ?>
    <!--first start -->
    <div class="first first_js" style="background-image: url(<?= $hot->hotPictureFile->getPicture();?>);">
        <div class="first__content">
            <div class="center clearfix first_height_js">
                <div class="first__shock first__shock_js">
                    <div class="first__time">
                        <div class="announcement__time">
                            <i class="icon-time"></i>
                            <span id="nowTime"><?= \Yii::$app->formatter->asDate(time(), 'php:H:i'); ?></span>
                            <span><?= \Yii::$app->formatter->asDate(time(), 'php:j F Y')?> г.</span>
                        </div>
                    </div>
                    <div class="first__shocktable first__shocktable-js">
                        <div class="first__shockmiddle">
                            <div class="announcement">
                                <a href="<?= Html::encode(NewsHelper::url($hot))?>" class="announcement__title opacity">
                                    <?= Html::encode($hot->title); ?>
                                </a>
                                <div class="announcement__date">
                                    <?= Html::encode(\Yii::$app->formatter->asRelativeTime($hot->created_at));?>
                                </div>
                                <div class="announcement__description">
                                    <?= Html::encode(\strip_tags($hot->preview_text)); ?>
                                </div>
                                <div class="announcement__tags">
                                    <a href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $hot->rubricAssignments[0]->rubric->slug]))?>" class="tag tag_transparent"><?= Html::encode($hot->rubricAssignments[0]->rubric->name);?></a>
                                </div>
                                <div class="announcement__autor">
                                    <img class="announcement__autorface" src="<?= $hot->author->getPhotoMin('40x40'); ?>" alt="<?= Html::encode($hot->author->getFullName()); ?>">
                                    <span class="announcement__autorname"><?= Html::encode($hot->author->getFullName()); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if (!empty($news)):
                    $first = $news[0];?>
                    <div class="first__additional first__additional-js">
                        <div class="clipping clipping_mosaic">
                            <div class="clipping__photo clearfix">
                                <div class="clipping__background" style="background-color: #101620;"></div>
                                <?php if($first->square_picture): ?>
                                    <img src="<?= $first->squarePictureFile->getPicture(); ?>" alt="<?= Html::encode($first->title); ?>">
                                <?php endif; ?>
                                <div class="clipping__tags">
                                    <a href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $first->rubricAssignments[0]->rubric->slug]))?>" class="tag tag_white">
                                        <?= Html::encode($first->rubricAssignments[0]->rubric->name); ?>
                                    </a>
                                </div>
                            </div>
                            <div class="clipping__time">
                                <div class="time">
                                    <span class="time__ego">
                                        <?= \Yii::$app->formatter->asRelativeTime($first->created_at);?>
                                    </span>
                                </div>
                            </div>
                            <a class="clipping__title title" href="<?= Html::encode(NewsHelper::url($first))?>">
                                <?= Html::encode(StringHelper::truncateWords($first->title, 5)); ?>
                            </a>
                        </div>

                        <?php
                        unset($news[0]);

                        $newsMobile = '';

                        if (!empty($news)): ?>
                            <div class="first__band">
                                <div class="band band_transparent">
                                    <ul class="band__list">
                                        <?php foreach ($news as $post): ?>
                                            <li class="band__item">
                                                <div class="band__content">
                                                    <div class="band__time">
                                                        <div class="time">
                                                            <span class="time__ego">
                                                                <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <a href="<?= Html::encode(NewsHelper::url($post))?>" class="band__name title">
                                                        <?= Html::encode($post->title); ?>
                                                    </a>
                                                    <div class="band__tags">
                                                        <a href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $post->rubricAssignments[0]->rubric->slug]))?>" class="tag tag_white">
                                                            <?= Html::encode($post->rubricAssignments[0]->rubric->name); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $newsMobile .= '<li class="band__item">
                                                        <div class="band__content">
                                                            <a href="'. Html::encode(NewsHelper::url($post)) .'" class="band__name title">
                                                                '. Html::encode($post->title) .'
                                                            </a>
                                                            <div class="band__time">
                                                                <div class="time">
                                                                    <span class="time__ego">'. \Yii::$app->formatter->asRelativeTime($post->created_at) .'</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>';
                                        endforeach; ?>
                                    </ul>
                                </div>
                                <div class="first__all">
                                    <a href="<?= Url::toRoute(['posts/rubrics/index', 'rubric' => 'news'])?>" class="btn btn_inline btn_big btn_transparent">Вся лента</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!--first end -->
<?php else:
    $first = $news[0];
    $second = $news[1];

    unset($news[0], $news[1]);?>
    <!--second start -->
    <div class="grid">
        <div class="second">
            <div class="center">
                <div class="row">
                    <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-12 col-md-7 col-lg-7">
                        <div class="second__time">
                            <div class="announcement__time">
                                <i class="icon-time-black"></i>
                                <span style=""><?= \Yii::$app->formatter->asDate(time(), 'php:H:i'); ?></span>
                                <span><?= \Yii::$app->formatter->asDate(time(), 'php:j F Y')?> г.</span>
                            </div>
                        </div>
                        <div class="grid__item">
                            <div class="analysis analysis_detector">
                                <div class="analysis__content">
                                    <div class="analysis__table">
                                        <div class="analysis__tr">
                                            <div class="analysis__announcement">
                                                <div class="announcement">

                                                    <a href="<?= Html::encode(NewsHelper::url($first))?>" class="announcement__title opacity">
                                                        <?= Html::encode($first->title); ?>
                                                    </a>
                                                    <div class="analysis__data">
                                                        <a href="<?= Html::encode(NewsHelper::url($first))?>" class="tag tag_policy">
                                                            <?= Html::encode($first->rubricAssignments[0]->rubric->name); ?>
                                                        </a>
                                                        <span class="announcement__time">
                                                            <span><?= \Yii::$app->formatter->asRelativeTime($first->created_at); ?></span>
                                                        </span>
                                                    </div>
                                                    <div class="analysis__description">
                                                        <div class="announcement__description">
                                                            <?= Html::encode(\strip_tags($first->preview_text)); ?>
                                                        </div>
                                                    </div>
                                                    <div class="announcement__autor">
                                                        <img class="announcement__autorface" src="<?= $first->author->getPhotoMin('40x40'); ?>" alt="<?= Html::encode($first->author->getFullName()); ?>">
                                                        <span class="announcement__autorname"><?= Html::encode($first->author->getFullName()); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="analysis__img" style="background-image: url(<?= $first->squarePictureFile ? $first->squarePictureFile->getPicture() : ''; ?>);">
                                    <?php if ($first->squarePictureFile): ?>
                                        <img src="<?= $first->squarePictureFile->getPicture(); ?>" alt="<?= Html::encode($first->title); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-12 col-md-5 col-lg-5">
                        <div class="grid__item">
                            <div class="analysis analysis_transparent">
                                <div class="analysis__content">
                                    <div class="analysis__table">
                                        <div class="analysis__tr">
                                            <div class="analysis__announcement">
                                                <div class="announcement">
                                                    <a href="<?= Html::encode(NewsHelper::utl($second))?>" class="announcement__title opacity">
                                                        <?= Html::encode($second->title); ?>
                                                    </a>
                                                    <div class="analysis__data">
                                                      <span class="announcement__time">
                                                          <span><?= \Yii::$app->formatter->asRelativeTime($second->created_at); ?></span>
                                                      </span>
                                                    </div>
                                                    <div class="analysis__description">
                                                        <div class="announcement__description">
                                                            <?= Html::encode(\strip_tags($second->preview_text)); ?>
                                                        </div>
                                                    </div>
                                                    <div class="announcement__autor">
                                                        <img class="announcement__autorface" src="<?= $first->author->getPhotoMin('40x40'); ?>" alt="<?= Html::encode($first->author->getFullName()); ?>">
                                                        <span class="announcement__autorname"><?= Html::encode($first->author->getFullName()); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="analysis__img" style="background-image: url(<?= $second->squarePictureFile ? $second->squarePictureFile->getPicture() : ''; ?>);">
                                    <?php if ($second->squarePictureFile): ?>
                                        <img src="<?= $second->squarePictureFile->getPicture(); ?>" alt="<?= Html::encode($second->title); ?>">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="second__band">
                    <div class="grid__item">
                        <div class="band band_horizontal">
                            <ul class="band__list">
                                <?php
                                foreach ($news as $post): ?>
                                    <li class="band__item">
                                        <div class="band__content">
                                            <a href="<?= Html::encode(NewsHelper::url($post)); ?>" class="band__name title">
                                                <?= Html::encode($post->title); ?>
                                            </a>
                                            <div class="band__time">
                                                <div class="time">
                                                    <span class="time__ego"><?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--second end -->
<?php endif; ?>

<?php if (!empty($rubrics)):
    foreach ($rubrics as $rubric):
        /** @var News $analytic */
        $analytic = $rubric->analytic;
        if ($analytic): ?>
            <div class="grid__block">
                <div class="grid_border">
                    <hr style="background: #222;">
                </div>
                <div class="center">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="grid__analysis">
                                <a href="<?= Html::encode(NewsHelper::url($analytic)); ?>" class="analysis" style="background-color: <?= $analytic->color; ?>;">
                                    <div class="analysis__background"></div>
                                    <div class="analysis__content">
                                        <div class="analysis__table">
                                            <div class="analysis__tr">
                                                <div class="analysis__announcement">
                                                    <div class="announcement">
                                                        <div class="announcement__time">
                                                            <span><?= \Yii::$app->formatter->asDate($analytic->created_at, 'php:H:i'); ?></span>
                                                            <span><?= \Yii::$app->formatter->asDate($analytic->created_at, 'php:j F Y')?> г.</span>
                                                        </div>
                                                        <div class="announcement__title opacity">
                                                            <?= Html::encode($analytic->title); ?>
                                                        </div>
                                                        <div class="announcement__autor">
                                                            <img class="announcement__autorface" src="<?= $analytic->author->getPhotoMin('40x40'); ?>" alt="<?= Html::encode($analytic->author->getFullName()); ?>">
                                                            <span class="announcement__autorname"><?= Html::encode($analytic->author->getFullName()); ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="analysis__table2">
                                            <div class="analysis__tr">
                                                <div class="analysis__description">
                                                    <div class="announcement__description">
                                                        <?= Html::encode(\strip_tags($analytic->preview_text)); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="analysis__img" style="background-image: url(<?= $analytic->rectanglePictureFile ? $analytic->rectanglePictureFile->getPicture() : '';?>);"></div>
                                    <div class="analysis__more"></div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;

        if ($rubric->news) {
            echo $this->render("templates/_{$rubric->template}", [
                'news' => $rubric->news,
                'color' => $rubric->color,
                'name' => $rubric->name,
                'alias' => $rubric->alias,
            ]);
        } ?>

    <?php endforeach;
endif; ?>

<?php echo  \frontend\widgets\posts\RubricsWidget::widget([
    'sort' => [
        'discussing' => 'Обсуждают',
        'reading' => 'Читают',
        'choice' => 'Выбор редакции'
    ]
]);?>