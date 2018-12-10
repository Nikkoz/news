<?php
/* @var $news \news\entities\posts\News[] */

use yii\helpers\Url;
use yii\helpers\Html;
use news\helpers\NewsHelper;

$rubric = $news[0]->rubricAssignments[0]->rubric;
?>
<div class="mainnews">
    <h3 class="mainnews__title">Выбор редакции</h3>
    <div class="clipping clipping_mosaic" data-ad-client="<?= $news[0]->id;?>">
        <div class="clipping__photo clearfix">
            <div class="clipping__background" style="background-color: #F2F2F2;"></div>
            <img src="<?= $news[0]->getSquarePicture(); ?>" alt="<?= Html::decode($news[0]->title); ?>">
            <div class="clipping__tags">
                <a href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]))?>" class="tag tag_white"><?= $news[0]->rubricAssignments[0]->rubric->name; ?></a>
            </div>
        </div>
        <div class="clipping__time">
            <div class="time">
                <span class="time__ego"><?= \Yii::$app->formatter->asRelativeTime($news[0]->created_at); ?></span>
            </div>
        </div>
        <a class="clipping__title title" href="<?= Html::encode(NewsHelper::url($news[0], $rubric->slug)); ?>">
            <?= Html::decode($news[0]->title); ?>
        </a>
    </div>

    <div class="band band_img band_paddingnone">
        <ul class="band__list">
            <?php unset($news[0]);

            foreach ($news as $post): ?>
                <li class="band__item  clearfix">
                    <div class="band__img">
                        <img src="<?= $post->getSquarePicture('64x64'); ?>" alt="<?= Html::encode($post->title); ?>">
                    </div>
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
