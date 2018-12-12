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
                                                    <span class="announcement__autorname"><?= Html::encode($news[0]->author->getFullName()); ?></span>
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
            <div class="row">
                <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="grid__item">
                        <div class="band band_horizontal">
                            <ul class="band__list">
                                <?php for ($f = 1; $f < 5; $f++):
                                    if (!isset($news[$f])) {
                                        break;
                                    }

                                    $post = $news[$f];
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
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($news[$f])): ?>
                <div class="row">
                    <?php for($s = $f; $s < $f + 2; $s++):
                        if (!isset($news[$s])) {
                            break;
                        }

                        $post = $news[$s];
                        $tags[] = $post->getTags();
                        ?>
                        <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-6 col-lg-6" data-id="<?= $post->id;?>">
                            <div class="grid__item">
                                <a href="<?= NewsHelper::url($post, $rubric->slug); ?>" class="card card_full card_full_biggest" style="background-image:url(<?= $post->getRectanglePicture();?>);">
                                    <div class="card__photo">
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
                    <?php endfor; ?>
                </div>
                <?php if (isset($news[$s])):
                    $tags[] = $news[$s]->getTags();?>
                    <div class="row">
                        <div class="col-xs-12  col-xxsm-12 col-xsm-12  col-sm-4 col-md-6 col-lg-6">
                            <div class="grid__item">
                                <a href="<?= NewsHelper::url($news[$s], $rubric->slug); ?>" class="card card_full card_full_biggest" style="background-image:url(<?= $news[$s]->getRectanglePicture(); ?>);">
                                    <div class="card__photo">
                                        <img src="<?= $news[$s]->getRectanglePicture(); ?>" alt="<?= Html::encode($news[$s]->title); ?>">
                                        <div class="card__content">
                                            <div class="card__titlebox">
                                                <div class="card__title title">
                                                    <?= Html::encode($news[$s]->title); ?>
                                                </div>
                                            </div>
                                            <div class="card__time">
                                                <div class="time">
                                                    <span class="time__ego">
                                                        <?= \Yii::$app->formatter->asRelativeTime($news[$s]->created_at); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-xs-12  col-xxsm-12 col-xsm-12  col-sm-8 col-md-6 col-lg-6">
                            <div class="row">
                                <?php for ($t = ++$s; $t < $s + 2; $t++):
                                    if (!isset($news[$t])) {
                                        break;
                                    }

                                    $post = $news[$t];
                                    $tags[] = $post->getTags();?>
                                    <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-6 col-lg-6">
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
                        </div>
                    </div>
                <?php endif;

                if (isset($news[$t])): ?>
                    <div class="row">
                        <?php
                        $iteration = 0;
                        for ($f = $t; $f < $t + 3; $f++):
                            if (!isset($news[$f])) {
                                break;
                            }

                            $post = $news[$f];
                            $tags[] = $post->getTags();

                            if ($iteration % 2 === 0): ?>
                                <div class="col-xs-12  col-xxsm-12 col-xsm-4  col-sm-4 col-md-3 col-lg-3">
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
                            <?php else: ?>
                                <div class="col-xs-12  col-xxsm-12 col-xsm-4  col-sm-4 col-md-6 col-lg-6">
                                    <div class="grid__item">
                                        <a href="<?= NewsHelper::url($post,  $rubric->slug); ?>" class="card card_full card_full_biggest" style="background-image:url(<?= $post->getRectanglePicture();?>);">
                                            <div class="card__photo">
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
                <?php endif;

                if (isset($news[$f])): ?>
                    <div class="row">
                        <?php for ($ff = $f; $ff < \count($news); $ff++):
                            if (!isset($news[$ff])) {
                                break;
                            }

                            $post = $news[$ff];
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
                <?php endif;
            endif; ?>
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
