<?php
/* @var $news \news\entities\posts\News[] */

use yii\helpers\Url;
use yii\helpers\Html;
?>
<div class="owl-carousel owl-theme mnt__list  mnt_js">
    <?php foreach ($news as $article): ?>
        <div class="mnt__item item">
            <div class="band__item  clearfix">
                <div class="band__img">
                    <img src="<?= $article->getSquarePicture('64x64'); ?>" alt="<?= Html::encode($article->title); ?>">
                </div>
                <div class="band__content">
                    <a href="<?= Url::to(['posts/rubrics/post', 'rubric' => $article->rubricAssignments[0]->rubric->slug, 'post' => $article->alias]); ?>" class="band__name title">
                        <?= Html::encode($article->title); ?>
                    </a>
                    <div class="band__time">
                        <div class="time">
                            <span class="time__ego">
                                <?= \Yii::$app->formatter->asRelativeTime($article->created_at); ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
