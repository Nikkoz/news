<?php

/* @var $dataProvider \yii\data\DataProviderInterface */

/* @var $rubric \news\entities\posts\rubric\Rubrics */

use yii\helpers\Url;
use yii\helpers\Html;
use news\helpers\NewsHelper;

/** @var \news\entities\posts\News[] $news */
$news = $dataProvider->getModels();

$tags[] = $news[0]->getTags();
?>
<div class="roubric">
    <div class="center">
        <div class="grid" id="newsBlock">
            <div class="row">
                <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="grid__item">
                        <a href="<?= NewsHelper::url($news[0], $rubric->slug); ?>" class="analysis analysis_roubric">
                            <div class="analysis__content">
                                <div class="analysis__table">
                                    <div class="analysis__tr">
                                        <div class="analysis__announcement">
                                            <div class="announcement">
                                                <div class="announcement__time">
                                                    <span>
                                                        <?= \Yii::$app->formatter->asRelativeTime($news[0]->created_at); ?>
                                                    </span>
                                                </div>
                                                <div class="announcement__title opacity">
                                                    <?= Html::encode($news[0]->title); ?>
                                                </div>
                                                <div class="announcement__autor">
                                                    <img class="announcement__autorface" src="<?= $news[0]->author->getPhotoMin('40x40');?>" alt="<?= Html::encode($news[0]->author->getFullName()); ?>">
                                                    <span class="announcement__autorname">
                                                        <?= Html::encode($news[0]->author->getFullName()); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="analysis__img" style="background-image: url(<?= $news[0]->getRectanglePicture(); ?>);">
                                <img src="<?= $news[0]->getRectanglePicture(); ?>" alt="<?= Html::encode($news[0]->title); ?>">
                            </div>
                            <div class="analysis__more"></div>
                        </a>
                    </div>
                </div>
            </div>

            <?php if (isset($news[1])): ?>
                <div class="row">
                    <!-- cards start -->
                    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                        <div class="row">
                            <?php
                            $iteration = 0;
                            for ($f = 1; $f < 3; $f++):
                                if (!isset($news[$f])) {
                                    break;
                                }

                                $post = $news[$f];
                                $tags[] = $post->getTags();

                                if ($iteration % 2 === 0): ?>
                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                        <div class="grid__item">
                                            <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_full" style="background-image: url(<?= $post->getRectanglePicture();?>)">
                                                <div class="card__photo" style="min-height: 344px;">
                                                    <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                                    <div class="card__content">
                                                        <div class="card__titlebox">
                                                            <div class="card__title title">
                                                                <?= Html::encode($post->title); ?>
                                                            </div>
                                                        </div>
                                                        <div class="card__time">
                                                            <div class="time">
                                                                <span class="time__ego">
                                                                    <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="grid__item">
                                            <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_standart card_border">
                                                <div class="card__photo">
                                                    <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                                </div>
                                                <div class="card__content">

                                                    <div class="card__titlebox">
                                                        <div class="card__title title">
                                                            <?= Html::encode($post->title); ?>
                                                        </div>
                                                    </div>
                                                    <div class="card__time">
                                                        <div class="time">
                                                            <span class="time__ego">
                                                                <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif;

                                $iteration++;
                            endfor; ?>
                        </div>
                        <?php if (isset($news[$f])): ?>
                            <div class="row">
                                <?php
                                $iteration = 0;
                                for ($s = $f; $s < $f + 2; $s++):
                                    if (!isset($news[$s])) {
                                        break;
                                    }

                                    $post = $news[$s];
                                    $tags[] = $post->getTags();

                                    if ($iteration % 2 === 0): ?>
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                            <div class="grid__item">
                                                <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_standart card_border">
                                                    <div class="card__photo">
                                                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                                    </div>
                                                    <div class="card__content">

                                                        <div class="card__titlebox">
                                                            <div class="card__title title">
                                                                <?= Html::encode($post->title); ?>
                                                            </div>
                                                        </div>
                                                        <div class="card__time">
                                                            <div class="time">
                                                                <span class="time__ego">
                                                                    <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                            <div class="grid__item">
                                                <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_full" style="background-image: url(<?= $post->getRectanglePicture();?>)">
                                                    <div class="card__photo" style="min-height: 344px;">
                                                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                                        <div class="card__content">
                                                            <div class="card__titlebox">
                                                                <div class="card__title title">
                                                                    <?= Html::encode($post->title); ?>
                                                                </div>
                                                            </div>
                                                            <div class="card__time">
                                                                <div class="time">
                                                                    <span class="time__ego">
                                                                        <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endif;

                                    $iteration++;
                                endfor; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!-- cards end -->
                    <?php if (isset($news[$s])): ?>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-band">
                            <div class="grid__item">
                                <div class="band band_gray band_media band_set_height-js">
                                    <div class="band__title">Новости</div>
                                    <ul class="band__list clearfix">
                                        <?php for ($t = $s; $t < $s + 8; $t++):
                                            if (!isset($news[$t])) {
                                                break;
                                            }

                                            $post = $news[$t];
                                            $tags[] = $post->getTags();
                                            ?>
                                            <li class="band__item">
                                                <div class="band__content">
                                                    <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="band__name title">
                                                        <?= Html::encode($post->title); ?>
                                                    </a>
                                                    <div class="band__time">
                                                        <div class="time">
                                                            <span class="time__ego">
                                                                <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        <?php endfor;?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif;

            if (isset($news[$t])): ?>
                <div class="row">
                    <?php for ($f = $t; $f < count($news); $f++):
                        if (!isset($news[$f])) {
                            break;
                        }

                        $post = $news[$f];
                        $tags[] = $post->getTags();
                        ?>
                        <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-3 col-lg-3">
                            <div class="grid__item">
                                <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_standart card_border  card_background_gray">
                                    <div class="card__photo">
                                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                    </div>
                                    <div class="card__content">
                                        <div class="card__titlebox">
                                            <span class="card__title title">
                                                <?= Html::encode($post->title); ?>
                                            </span>
                                        </div>
                                        <div class="card__time">
                                            <div class="time">
                                                <span class="time__ego">
                                                    <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="center">
    <?php
    $pagination = $dataProvider->getPagination();

    if ($pagination->getPageCount() > $pagination->getPage() + 1): ?>
        <a href="<?= Url::to(['posts/rubrics/load', 'id' => $rubric->id]);?>" data-offset="<?= \count($news);?>" class="more" id="btnLoadPosts">
            <span class="more__icon"></span>
            Показать еще
        </a>
    <?php endif;
    $tags = \array_unique(\call_user_func_array('array_merge', $tags ?: []));

    if ($tags): ?>
        <div class="related">
            <h3 class="related__title">Материалы по темам:</h3>
            <?php foreach ($tags as $tag): ?>
                <a href="<?= Url::to(['tag', 'tag' => $tag]); ?>" class="btn btn_inline btn_light"><?= $tag; ?></a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>