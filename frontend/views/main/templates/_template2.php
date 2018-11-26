<?php
/** @var $news \news\entities\posts\News */
/** @var $color string */
/** @var $name string */
/** @var $alias string */

use yii\helpers\Html;
use news\entities\posts\News;
use yii\helpers\Url;
use news\helpers\ColorHelper;

/** @var News $post */
$post = $news[0];
?>
<div class="grid__block grid_paddingtop grid_gray">
    <div class="grid_border">
        <hr style="background: <?= $color; ?>;">
    </div>

    <div class="center">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hide-xsm hide-xxsm hide-xs">
                        <div class="grid__item">
                            <a href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="analysis analysis_flat" data-id="<?= $post->id;?>">
                                <div class="analysis__content">
                                    <div class="analysis__table">
                                        <div class="analysis__tr">
                                            <div class="analysis__announcement">
                                                <div class="announcement">
                                                    <div class="announcement__time">
                                                        <span><?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?></span>
                                                    </div>
                                                    <div class="announcement__title opacity">
                                                        <?= Html::encode($post->title);?>
                                                    </div>
                                                    <div class="analysis__description">
                                                        <div class="announcement__description">
                                                            <?= Html::encode(\strip_tags($post->preview_text)); ?>
                                                        </div>
                                                    </div>
                                                    <div class="announcement__autor">
                                                        <img class="announcement__autorface" src="<?= $post->author->getPhotoMin('40x40'); ?>" alt="<?= Html::encode($post->author->getFullName()); ?>">
                                                        <span class="announcement__autorname"><?= Html::encode($post->author->getFullName()); ?></span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="analysis__img" style="background-image: url(<?= $post->getRectanglePicture();?>);">
                                    <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                </div>
                                <div class="analysis__more"></div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php if (isset($news[1])): ?>
                    <div class="row">
                        <?php for($i = 1; $i <= 2; $i++):
                            if (!isset($news[$i])) {
                                break;
                            }

                            $post = $news[$i];
                            $rgb = ColorHelper::hexToRgb($color);?>

                            <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-6 col-lg-6">
                                <div class="grid__item">
                                    <a href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="card card_standart card_background_gray">
                                        <div class="card__photo">
                                            <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                        </div>
                                        <div class="card__content">
                                            <div class="card__tags">
                                                <span
                                                    data-href="<?= Html::encode(Url::toRoute(['rubrics/index', 'rubric' => $alias]))?>"
                                                    class="tag tag_border_hover"
                                                    style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                                                    <?= Html::encode($name); ?>
                                                </span>
                                            </div>
                                            <div class="card__titlebox">
                                                <span class="card__title title">
                                                    <?= Html::encode($post->title);?>
                                                </span>
                                            </div>
                                            <div class="card__time">
                                                <div class="time">
                                                    <span class="time__ego"><?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?></span>
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
            <?php if (isset($news[$i])): ?>
                <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="grid__item">
                        <div class="band band_light band_set_height-js">
                            <div class="band__title"><?= $name; ?></div>
                            <ul class="band__list">
                                <?php for ($j = $i; $j < count($news); $j++):
                                    if (!isset($news[$j])) {
                                        break;
                                    }

                                    $post = $news[$j];?>

                                    <li class="band__item">
                                        <div class="band__content">
                                            <a href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $alias, 'post' => $post->alias])); ?>" class="band__name title">
                                                <?= Html::encode($post->title);?>
                                            </a>
                                            <div class="band__time">
                                                <div class="time">
                                                    <span class="time__ego"><?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
