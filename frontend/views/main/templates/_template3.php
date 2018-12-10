<?php

/** @var $news \news\entities\posts\News */
/** @var $color string */
/** @var $name string */
/** @var $alias string */

use yii\helpers\Html;
use news\entities\posts\News;
use yii\helpers\Url;
use news\helpers\NewsHelper;
?>
<div class="grid__block">
    <div class="grid_border">
        <hr style="background: <?= $color; ?>;">
    </div>

    <div class="center">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="grid__item">
                    <div class="band band_img band_border">
                        <div class="band__title"><?= $name; ?></div>
                        <ul class="band__list">
                            <?php for($i = 0; $i < 4; $i++):
                                if(!isset($news[$i])) {
                                    break;
                                }

                                /** @var News $post */
                                $post = $news[$i]; ?>
                                <li class="band__item  clearfix">
                                    <div class="band__img">
                                        <img src="<?= $post->getSquarePicture('64x64');?>" alt="<?= Html::encode($post->title);?>">
                                    </div>
                                    <div class="band__content">
                                        <a href="<?= Html::encode(NewsHelper::url($post, $alias)); ?>" class="band__name title">
                                            <?= Html::encode($post->title);?>
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
            <?php if ($news[$i]):
                $post = $news[$i];?>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="grid__item">
                        <a href="<?= Html::encode(NewsHelper::url($post, $alias)); ?>" class="analysis analysis_text">
                            <div class="analysis__content">
                                <div class="analysis__announcement">
                                    <div class="announcement">
                                        <div class="announcement__time">
                                            <span>
                                                <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                            </span>
                                        </div>
                                        <div class="announcement__title opacity">
                                            <?= Html::encode($post->title);?>
                                        </div>
                                        <div class="announcement__autor">
                                            <span class="announcement__autorname">
                                                <?= Html::encode($post->author->getFullName());?>
                                            </span>
                                        </div>
                                        <div class="analysis__description">
                                            <div class="announcement__description clearfix">
                                                <img src="<?= $post->getSquarePicture('120x120');?>" alt="<?= Html::encode($post->title);?>">
                                                <p>
                                                    <?= Html::encode(\strip_tags($post->preview_text));?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endif;

            if($news[++$i]): ?>
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                    <div class="row">
                        <?php for($s = $i; $s < $i + 2; $s++):
                            if(!isset($news[$s])) {
                                break;
                            }

                            $post = $news[$s]; ?>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" data-id="<?= $post->id;?>">
                                <div class="grid__item">
                                    <a href="<?= Html::encode(NewsHelper::url($post, $alias)); ?>" class="card card_small">
                                        <div class="card__photo">
                                            <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                        </div>
                                        <div class="card__content">
                                            <div class="card__time">
                                                <div class="time">
                                                    <span class="time__ego">
                                                        <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="card__titlebox">
                                                <div class="card__title title">
                                                    <?= Html::encode($post->title);?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endfor;

                        if ($news[$s]): ?>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="grid__item">
                                    <a href="<?= Html::encode(NewsHelper::url($post, $alias)); ?>" class="clipping clipping_card">
                                        <div class="clipping__photo">
                                            <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                            <div class="clipping__content">
                                                <div class="clipping__title title">
                                                    <?= Html::encode($post->title);?>
                                                </div>
                                                <div class="clipping__time">
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
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php if (isset($news[++$s])): ?>
            <div class="row">
                <?php for($t = $s; $t < count($news); $t++):
                    if (!isset($news[$t])) {
                        break;
                    }

                    $post = $news[$t];?>
                    <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="grid__item">
                            <a href="<?= Html::encode(NewsHelper::url($post, $alias)); ?>" class="card card_full card_full_biggest" style="background-image: url('<?= $post->getRectanglePicture();?>');">
                                <div class="card__photo">
                                    <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                    <div class="card__content">
                                        <div class="card__tags">
                                            <span data-href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $alias]))?>" class="tag tag_white">
                                                <?= Html::encode($name); ?>
                                            </span>
                                        </div>
                                        <div class="card__titlebox">
                                            <div class="card__title title">
                                                <?= Html::encode($post->title);?>
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
        <?php endif; ?>
    </div>
</div>
