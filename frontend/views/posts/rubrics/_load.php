<?php
/* @var $news \news\entities\posts\News[] */
/* @var $rubric string */
/* @var $isNews bool */

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div class="row">
    <?php for ($f = 0; $f < 2; $f++):
        if (!isset($news[$f])) {
            break;
        }
        $article = $news[$f]; ?>
        <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-6 col-lg-6">
            <div class="grid__item">
                <a href="<?= Url::toRoute(['posts/rubrics/post', 'rubric' => $isNews ? $article->rubricAssignments[0]->rubric->slug : $rubric, 'post' => $article->alias]); ?>" class="card card_full card_full_biggest" style="background-image:url(<?= $article->getRectanglePicture();?>);">
                    <div class="card__photo">
                        <img src="<?= $article->getRectanglePicture();?>" alt="<?= Html::encode($article->title); ?>">
                        <div class="card__content">
                            <div class="card__titlebox">
                                <div class="card__title title">
                                    <?= Html::encode($article->title); ?>
                                </div>
                            </div>
                            <div class="card__time">
                                <div class="time">
                                    <span class="time__ego">
                                        <?= \Yii::$app->formatter->asRelativeTime($article->created_at); ?>
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
<?php if (isset($news[$f])): ?>
    <div class="row">
        <?php for($s = $f; $s < count($news); $s++):
            if (!isset($news[$s])) {
                break;
            }

            $article = $news[$s];?>
            <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-3 col-lg-3">
                <div class="grid__item">
                    <a href="<?= Url::toRoute(['posts/rubrics/post', 'rubric' => $isNews ? $article->rubricAssignments[0]->rubric->slug : $rubric, 'post' => $article->alias]); ?>" class="card card_standart card_border  card_background_gray">
                        <div class="card__photo">
                            <img src="<?= $article->getRectanglePicture();?>" alt="#">
                        </div>
                        <div class="card__content">
                            <div class="card__titlebox">
                                <span class="card__title title">
                                    <?= Html::encode($article->title); ?>
                                </span>
                            </div>
                            <div class="card__time">
                                <div class="time">
                                    <span class="time__ego">
                                        <?= \Yii::$app->formatter->asRelativeTime($article->created_at); ?>
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