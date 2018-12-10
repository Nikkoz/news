<?php
/** @var $this \yii\web\View */
/** @var $post \news\entities\posts\News */
/** @var $posts \news\entities\posts\News[] */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $post->getSeoTitle();

$this->registerMetaTag(['name' => 'description', 'content' => $post->meta->description]);
$this->registerMetaTag(['name' => 'keywords', 'content' => $post->meta->keywords]);

$tags = $post->getTags();
?>
<div class="first first_analistic first_js" style="background-color: #0C0D11;">
    <div class="first__content">
        <div class="clearfix first_height_js">
            <div class="first__shock first__shock_js">
                <div class="first__shocktable first__shocktable-js">
                    <div class="first__shockmiddle">
                        <div class="announcement">
                            <div class="announcement__autor">
                                <img class="announcement__autorface" src="<?= $post->author->getPhotoMin('64x64'); ?>" alt="<?= $post->author->getFullName(); ?>">
                                <span class="announcement__autorname"><?= $post->author->getFullName(); ?></span>
                            </div>
                            <a href="#" class="announcement__title opacity">
                                <?= Html::encode($post->title); ?>
                            </a>
                            <div class="announcement__date">
                                <?= \Yii::$app->formatter->asRelativeTime($post->created_at); ?>
                            </div>
                            <div class="announcement__description">
                                <?= $post->preview_text; ?>
                            </div>
                            <div class="announcement__tags">
                                <?php foreach ($post->rubricAssignments as $rubricAssignment):
                                    $rubric = $rubricAssignment->rubric;?>
                                    <a href="<?= Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug])?>" class="tag tag_transparent"><?= $rubric->name; ?></a>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="first_backimage" style="background-image: url(<?= $post->getAnalyticPicture()?>);"></div>
</div>

<div class="grid">
    <div class="center pagecontent pagecontent-js">
        <div class="row">
            <div class="col-xs-12 col-xxsm-12 col-xsm-12 col-sm-7 col-md-7 col-lg-7 pagecontent__material">
                <div class="">
                    <div class="content">
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
                    <div class="pagecontent__socialbottom"></div>
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
