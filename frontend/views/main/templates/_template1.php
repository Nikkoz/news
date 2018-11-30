<?php
/** @var $news \news\entities\posts\News */
/** @var $color string */
/** @var $name string */
/** @var $alias string */

use yii\helpers\Html;
use news\entities\posts\News;
use yii\helpers\Url;
use news\helpers\ColorHelper;
?>
<div class="grid__block grid_paddingnone">
    <div class="grid_border">
        <hr style="background: <?= $color; ?>;">
    </div>
    <div class="center">
        <div class="row">
            <!-- band start -->
            <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-4 col-md-3 col-lg-3">
                <div class="grid__item">
                    <div class="band band_light band_media band_set_height-js">
                        <div class="band__title"><?= $name; ?></div>
                        <ul class="band__list clearfix">
                            <?php for($i = 0; $i < 10; $i++):
                                if (!isset($news[$i])) {
                                    continue;
                                }

                                /** @var News $post */
                                $post = $news[$i];
                                ?>
                                <li class="band__item">
                                    <div class="band__content">
                                        <a href="<?= Html::encode(Url::to(['posts/rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="band__name title">
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
            <!-- band end -->

            <!-- cards start -->
            <?php if (isset($news[$i])): ?>
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                    <div class="row">
                        <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-4 col-lg-4">
                            <div class="grid__item">
                                <?php
                                /** @var News $post */
                                $post = $news[$i];

                                $rgb = ColorHelper::hexToRgb($color);
                                ?>
                                <a href="<?= Html::encode(Url::to(['posts/rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="card card_standart card_border">
                                    <div class="card__photo">
                                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                    </div>
                                    <div class="card__content">

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
                                        <div class="card__tags">
                                            <span
                                                data-href="<?= Html::encode(Url::toRoute(['rubrics/index', 'rubric' => $alias]))?>"
                                                class="tag tag_border_hover"
                                                style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                                                <?= Html::encode($name); ?>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                        $i++;

                        if (isset($news[$i])):
                            $post = $news[$i];?>
                            <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-8 col-lg-8">
                                <div class="grid__item">
                                    <a href="<?= Html::encode(Url::to(['posts/rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="card card_full" style="background-image: url(<?= $post->getRectanglePicture();?>)">
                                        <div class="card__photo">
                                            <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                            <div class="card__content">
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
                                                <div class="card__tags">
                                                    <span data-href="<?= Html::encode(Url::toRoute(['rubrics/index', 'rubric' => $alias]))?>" class="tag tag_white">
                                                        <?= Html::encode($name); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    $i++;
                    if (isset($news[$i])): ?>
                        <div class="row">
                            <?php for($j = $i; $j < count($news); $j++):
                                $post = $news[$j];

                                $rgb = ColorHelper::hexToRgb($color); ?>
                                <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-4 col-lg-4">
                                    <div class="grid__item">
                                        <a href="<?= Html::encode(Url::to(['posts/rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="card card_standart card_border">
                                            <div class="card__photo">
                                                <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                            </div>
                                            <div class="card__content">
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
                                                <div class="card__tags">
                                                    <span
                                                        data-href="<?= Html::encode(Url::toRoute(['rubrics/index', 'rubric' => $alias]))?>"
                                                        class="tag tag_border_hover"
                                                        style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                                                        <?= Html::encode($name); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- cards end -->
            <?php endif; ?>
        </div>
    </div>
</div>