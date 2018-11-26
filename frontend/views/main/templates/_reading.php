<?php
/** @var $news array */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<h3>Читают</h3>
<div class="row">
    <?php for ($f = 0; $f < 2; $f++):
        if (!isset($news[$f])) {
            break;
        }

        /** @var \news\entities\posts\News $post */
        $post = $news[$f];

        /** @var \news\entities\posts\rubric\Rubrics $rubric */
        $rubric = $post->rubricAssignments[0]->rubric;?>

        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="grid__item">
                <a href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $rubric->slug, 'post' => $post->alias])); ?>" class="card card_small">
                    <div class="card__photo">
                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
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
                                <?= Html::encode($post->title); ?>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    <?php endfor; ?>
</div>

<div class="grid__item">
    <div class="band band_paddingnone">
        <ul class="band__list">
            <?php for ($s = $f; $s < $f + 2; $s++):
                if (!isset($news[$s])) {
                    break;
                }

                /** @var \news\entities\posts\News $post */
                $post = $news[$s];

                /** @var \news\entities\posts\rubric\Rubrics $rubric */
                $rubric = $post->rubricAssignments[0]->rubric; ?>
                <li class="band__item">
                    <div class="band__content">
                        <a href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $rubric->slug, 'post' => $post->alias])); ?>" class="band__name title">
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

<div class="grid__item">
    <?php if ($news[$s]):
        $post = $news[$s];
        $rubric = $post->rubricAssignments[0]->rubric; ?>

        <div class="clipping clipping_mosaic" data-id="<?= $post->id;?>">
            <div class="clipping__photo clearfix">
                <div class="clipping__background" style="background-color: #F2F2F2;"></div>
                <img src="<?= $post->getSquarePicture();?>" alt="<?= Html::encode($post->title); ?>">
                <div class="clipping__tags">
                    <a href="<?= Html::encode(Url::toRoute(['rubrics/index', 'rubric' => $rubric->slug])); ?>" class="tag tag_white">
                        <?= Html::encode($rubric->name); ?>
                    </a>
                </div>
            </div>
            <div class="clipping__time">
                <div class="time">
                    <span class="time__ego">
                        <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                    </span>
                </div>
            </div>
            <a class="clipping__title title" href="<?= Html::encode(Url::toRoute(['rubrics/post', 'rubric' => $rubric->slug, 'post' => $post->alias])); ?>">
                <?= Html::encode($post->title); ?>
            </a>
        </div>
    <?php endif; ?>
</div>