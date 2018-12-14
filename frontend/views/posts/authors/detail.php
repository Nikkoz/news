<?php
/** @var $this \yii\web\View */
/** @var $author \news\entities\user\User */
/** @var $dataProvider \yii\data\DataProviderInterface */

use yii\helpers\Url;
use yii\helpers\Html;
use news\helpers\NewsHelper;
use news\helpers\ColorHelper;

$this->title = $author->getFullName();

$news = $dataProvider->getModels();
?>
<div class="autor">
    <div class="center">
        <div class="autor__info clearfix">
            <div class="autor__photo">
                <img src="<?= $author->getPhotoMin('144x144')?>" alt="<?= $author->getFullName(); ?>">
            </div>
            <div class="autor__name">
                <?= \str_replace(' ', '<br>', $author->getFullName(true)); ?>
            </div>
            <div class="autor__written">
                <b><?= $author->getCountPosts();?></b> статей
            </div>
            <div class="autor__all">
                <a href="<?= Url::toRoute(['posts/authors/index'])?>" class="btn btn_inline btn_white">Все авторы</a>
            </div>
        </div>
        <div class="autor__footer clearfix">
            <div class="autor__related">
                <div class="related">
                    <h3 class="related__title">Материалы по темам:</h3>
                    <a href="#" class="btn btn_inline btn_light">Отпуск</a>
                    <a href="#" class="btn btn_inline btn_light">Сочи</a>
                    <a href="#" class="btn btn_inline btn_light">Отдых на пляже</a>
                </div>
            </div>
            <div class="autor__all">
                <a href="<?= Url::toRoute(['posts/authors/index'])?>" class="btn btn_inline btn_white">Все авторы</a>
            </div>
        </div>
        <?php if ($news): ?>
            <div class="autor__articles">
                <div class="grid" id="newsBlock">
                    <div class="row">
                        <?php for ($f = 0; $f < 4; $f++):
                            if (!isset($news[$f])) {
                                continue;
                            }

                            /** @var \news\entities\posts\News $post */
                            $post = $news[$f]; ?>

                            <div class="col-xs-12 col-xxsm-6 col-xsm-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="grid__item">
                                    <a href="<?= Html::encode(NewsHelper::url($post)); ?>" class="card card_standart card_background_gray">
                                        <div class="card__photo">
                                            <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                        </div>
                                        <div class="card__content">
                                            <div class="card__titlebox">
                                                <span class="card__title title">
                                                  <?= Html::encode($post->title);?>
                                                </span>
                                            </div>
                                            <div class="card__time">
                                                <div class="time">
                                                    <span class="time__time"><?= \Yii::$app->formatter->asTime($post->created_at, 'php:H:i'); ?></span>
                                                    <span class="time__ego"><?= \Yii::$app->formatter->asDate($post->created_at, 'php:d.m.Y'); ?></span>
                                                </div>
                                            </div>
                                            <div class="card__tags">
                                                <?php foreach ($post->rubricAssignments as $rubricAssignment):
                                                    $rubric = $rubricAssignment->rubric;

                                                    $rgb = ColorHelper::hexToRgb($rubric->color);
                                                    ?>
                                                    <span href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]))?>"
                                                       class="tag tag_border_hover"
                                                       style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                                                        <?= Html::encode($rubric->name); ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <?php if (isset($news[$f])): ?>
                        <div class="row">
                            <?php for ($s = $f; $s < $f + 2; $s++):
                                if (!isset($news[$f])) {
                                    continue;
                                }

                                /** @var \news\entities\posts\News $post */
                                $post = $news[$f]; ?>

                                <div class="col-xs-12  col-xxsm-12 col-xsm-6  col-sm-6 col-md-6 col-lg-6">
                                    <div class="grid__item">
                                        <a href="<?= Html::encode(NewsHelper::url($post)); ?>" class="card card_full card_full_biggest" style="background-image:url('<?= $post->getRectanglePicture();?>');">
                                            <div class="card__photo">
                                                <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                                <div class="card__content">
                                                    <div class="card__tags">
                                                        <?php foreach ($post->rubricAssignments as $rubricAssignment):
                                                            $rubric = $rubricAssignment->rubric;
                                                            ?>
                                                            <span href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]))?>" class="tag tag_white">
                                                                <?= Html::encode($rubric->name); ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                    <div class="card__titlebox">
                                                        <div class="card__title title">
                                                            <?= Html::encode($post->title);?>
                                                        </div>
                                                    </div>
                                                    <div class="card__time">
                                                        <div class="time">
                                                            <span class="time__time"><?= \Yii::$app->formatter->asTime($post->created_at, 'php:H:i'); ?></span>
                                                            <span class="time__ego"><?= \Yii::$app->formatter->asDate($post->created_at, 'php:d.m.Y'); ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    <?php endif;

                    if (isset($news[$s])): ?>
                        <div class="row">
                            <?php for ($t = $s; $t < count($news); $t++):
                                if (!isset($news[$t])) {
                                    continue;
                                }

                                /** @var \news\entities\posts\News $post */
                                $post = $news[$t]; ?>

                                <div class="col-xs-12 col-xxsm-6 col-xsm-6 col-sm-6 col-md-3 col-lg-3">
                                    <div class="grid__item">
                                        <a href="<?= Html::encode(NewsHelper::url($post)); ?>" class="card card_standart card_background_gray">
                                            <div class="card__photo">
                                                <img src="<?= $post->getRectanglePicture();?>" alt="<?= Html::encode($post->title);?>">
                                            </div>
                                            <div class="card__content">
                                                <div class="card__titlebox">
                                                <span class="card__title title">
                                                  <?= Html::encode($post->title);?>
                                                </span>
                                                </div>
                                                <div class="card__time">
                                                    <div class="time">
                                                        <span class="time__time"><?= \Yii::$app->formatter->asTime($post->created_at, 'php:H:i'); ?></span>
                                                        <span class="time__ego"><?= \Yii::$app->formatter->asDate($post->created_at, 'php:d.m.Y'); ?></span>
                                                    </div>
                                                </div>
                                                <div class="card__tags">
                                                    <?php foreach ($post->rubricAssignments as $rubricAssignment):
                                                        $rubric = $rubricAssignment->rubric;

                                                        $rgb = ColorHelper::hexToRgb($rubric->color);
                                                        ?>
                                                        <span href="<?= Html::encode(Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]))?>"
                                                              class="tag tag_border_hover"
                                                              style="background-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.3);border-color: rgba(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>, 0.5);border:0;padding: 4px 9px;color: rgb(<?= $rgb['r'];?>, <?= $rgb['g'];?>, <?= $rgb['b'];?>);">
                                                        <?= Html::encode($rubric->name); ?>
                                                    </span>
                                                    <?php endforeach; ?>
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
        <?php endif; ?>
    </div><?php
    $pagination = $dataProvider->getPagination();

    if ($pagination->getPageCount() > $pagination->getPage() + 1): ?>
        <div class="autor__more">
            <a href="<?= Url::to(['posts/authors/load', 'id' => $author->id]);?>" data-offset="<?= \count($news);?>" class="more" id="btnLoadPosts">
                <span class="more__icon"></span>
                Показать еще
            </a>
        </div>
    <?php endif; ?>
</div>