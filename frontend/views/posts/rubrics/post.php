<?php
/** @var $this \yii\web\View */
/** @var $rubric \news\entities\posts\rubric\Rubrics */
/** @var $post \news\entities\posts\News */
/** @var $posts \news\entities\posts\News[] */

use yii\helpers\Url;
use yii\helpers\Html;
use news\helpers\ColorHelper;
use frontend\widgets\posts\MainNewsWidget;

$this->title = $post->getSeoTitle();

$this->registerMetaTag(['name' =>'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' =>'keywords', 'content' => $post->meta->keywords]);

$rgb = ColorHelper::hexToRgb($rubric->color);
$tags = $post->getTags();
?>
<div class="grid">
    <div class="center pagecontent">
        <div class="pagecontent__header">
            <div class="pagecontent__tags">
                <div class="tags">
                    <a href="<?= Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]); ?>"
                       class="tag tag_border_hover"
                       style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                        <?= Html::encode($rubric->name); ?>
                    </a>
                </div>
            </div>
            <h1 class="pagecontent__title">
                <?= Html::encode($post->title); ?>
            </h1>
        </div>
        <div class="pagecontent__socialtop">
            <!--social start -->
            <div class="social social_content clearfix">
                <div class="social__autor">
                    <div class="announcement__autor">
                        <img class="announcement__autorface" src="<?= $post->author->getPhotoMin('40x40'); ?>" alt="<?= $post->author->getFullName(); ?>">
                        <span class="announcement__autorname"><?= Html::encode($post->author->getFullName()); ?></span>
                    </div>
                </div>
                <div class="social__time">
                    <div class="time">
                        <span class="time__time"><?= \Yii::$app->formatter->asDate($post->created_at, 'php:d M Y'); ?> г.<span>
                        <span class="time__ego"><?= \Yii::$app->formatter->asTime($post->created_at, 'php:H:i'); ?></span>
                    </div>
                </div>
            </div>
            <!--social end -->
        </div>
        <div class="row">
            <div class="pagecontent__material col-xs-12 col-xxsm-12 col-xsm-12 col-sm-7 col-md-7 col-lg-7">
                <div class="">
                    <div class="content">
                        <?php if ($picture = $post->getRectanglePicture()): ?>
                            <figure class="figure">
                                <img src="<?= $picture; ?>" alt="<?= Html::encode($post->title);?>">
                            </figure>
                        <?php endif; ?>

                        <div>
                            <?php foreach ($post->detail_text as $data) {
                                if (isset($data['text']) && isset($data['tizer'])) {
                                    $template = 'tizer';
                                } elseif (isset($data['slider'])) {
                                    $template = 'slider';
                                } elseif (isset($data['video'])) {
                                    $template = 'video';
                                } else {
                                    $template = 'text';
                                }

                                echo $this->render("text/_{$template}", [
                                    'data' => $data
                                ]);
                            }?>
                        </div>
                    </div>
                </div>
                <?php if ($tags): ?>
                    <div class="pagecontent__related">
                        <div class="related">
                            <h3 class="related__title">Материалы по темам:</h3>
                            <?php foreach ($tags as $tag): ?>
                                <a href="<?= Url::to(['posts/rubrics/tag', 'tag' => $tag]); ?>" class="btn btn_inline btn_light"><?= $tag; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="pagecontent__righthand col-sm-4 col-md-4 col-lg-4 col-xs-push-1">
                <?= MainNewsWidget::widget();?>
            </div>
        </div>
        <div class="pagecontent__relatedcard">
            <!--related card  start -->
            <?php if ($posts): ?>
                <div class="related related_card">
                    <h3 class="related__title">Еще по теме</h3>
                    <div class="row">
                        <?php foreach ($posts as $post): ?>
                            <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-4 col-md-2 col-lg-2">
                                <a href="#" class="card card_small card_miracle">
                                    <div class="card__photo">
                                        <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title); ?>">
                                    </div>
                                    <div class="card__thumbnail">
                                        <img src="<?= $post->getSquarePicture('64x64');?>" alt="<?= Html::encode($post->title); ?>">
                                    </div>
                                    <div class="card__content">
                                        <div class="card__time">
                                            <div class="time">
                                                <span class="time__ego"><?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?></span>
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
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <!--related card  end -->
        </div>
    </div>
</div>