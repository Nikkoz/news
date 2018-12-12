<?php
/** @var $this \yii\web\View */
/** @var $tag string */
/** @var $tagId int */
/** @var $dataProvider \yii\data\DataProviderInterface */

use yii\helpers\Html;
use yii\helpers\Url;
use news\helpers\NewsHelper;

$posts = $dataProvider->getModels();

if ($posts): ?>
<div class="roubric">
    <div class="center">
        <div class="grid" id="newsBlock">
            <div class="row">
                <?php
                for ($i = 0; $i < 3; $i++):
                    if (!isset($posts[$i])) {
                        break;
                    }

                    /** @var \news\entities\posts\News $post */
                    $post = $posts[$i];

                    if ($i % 2 === 0): ?>
                        <div class="col-xs-12  col-xxsm-12 col-xsm-4  col-sm-4 col-md-3 col-lg-3">
                            <div class="grid__item">
                                <a href="<?= NewsHelper::url($post); ?>" class="card card_standart card_border  card_background_gray">
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
                                <a href="<?= NewsHelper::url($post); ?>" class="card card_full card_full_biggest" style="background-image:url(<?= $post->getRectanglePicture();?>);">
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
                endfor;

                if (isset($posts[$i])): ?>
                    <div class="row">
                        <?php for ($s = $i; $s < \count($posts); $s++):
                            if (!isset($posts[$s])) {
                                break;
                            }

                            $post = $posts[$s];
                            ?>
                            <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-3 col-lg-3">
                                <div class="grid__item">
                                    <a href="<?= NewsHelper::url($post); ?>" class="card card_standart card_border  card_background_gray">
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
</div>
<div class="center">
    <?php
    $pagination = $dataProvider->getPagination();

    if ($pagination->getPageCount() > $pagination->getPage() + 1): ?>
        <a href="<?= Url::to(['posts/post/load', 'id' => $tagId]);?>" data-offset="<?= \count($posts);?>" class="more" id="btnLoadPosts">
            <span class="more__icon"></span>
            Показать еще
        </a>
    <?php endif; ?>
</div>
<?php else: ?>
<div class="center">
    <p>Новостей с тэгом "<?= $tag; ?>" нет.</p>
</div>
<?php endif; ?>
