<?php
/* @var $news array */

use yii\helpers\Html;
use yii\helpers\Url;
use news\helpers\NewsHelper;

/** @var \news\entities\posts\News $post */
$post = $news[0];
unset($news[0]);
?>
<h3>Обсуждают</h3>

<?php if ($post): ?>
    <div class="grid__item">
        <?php
        /** @var \news\entities\posts\rubric\Rubrics $rubric */
        $rubric = $post->rubricAssignments[0]->rubric;
        ?>
        <div class="clipping clipping_mosaic">
            <div class="clipping__photo clearfix">
                <div class="clipping__background" style="background-color: #101620;"></div>
                <img src="<?= $post->getSquarePicture(); ?>" alt="<?= Html::encode($post->title); ?>">
                <div class="clipping__tags">
                    <a href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]))?>" class="tag tag_white">
                        <?= $rubric->name;?>
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
            <a class="clipping__title title" href="<?= Html::encode(NewsHelper::url($post, $rubric->slug)); ?>">
                <?= Html::encode($post->title); ?>
            </a>
        </div>
    </div>

    <?php if($news): ?>
        <div class="grid__item">
            <div class="band band_img band_paddingnone">
                <ul class="band__list">
                    <?php foreach ($news as $post): ?>
                        <li class="band__item  clearfix">
                            <div class="band__img">
                                <img src="<?= $post->getSquarePicture('64x64'); ?>" alt="<?= Html::encode($post->title); ?>">
                            </div>
                            <div class="band__content">
                                <a href="<?= Html::encode(NewsHelper::url($post, $rubric->slug)); ?>" class="band__name title">
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
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endif;
endif; ?>