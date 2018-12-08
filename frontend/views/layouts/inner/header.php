<?php
/* @var $this \yii\web\View */

use yii\helpers\Url;
use frontend\widgets\posts\ArticleCarouselWidget;
use yii\widgets\Menu;
?>
<header class="header <?= $this->params['pageParams']['header']; ?>">
    <div class="header__pantry">
        <div class="center clearfix">
            <!--header burger start -->
            <div class="header__burger">
                <a href="#" class="burger opacity">
                  <span class="burger__lines">
                      <span class="burger__1"></span>
                      <span class="burger__2"></span>
                      <span class="burger__3"></span>
                  </span>
                </a>
            </div>
            <!--header burger end -->
            <!--header logo start -->
            <a href="/" class="header__logo"></a>
            <!--header logo end -->
            <!--header navigatoin start -->
            <?php
            foreach ($this->params['rubrics'] as $rubric) {
                /** @var $rubric \news\entities\posts\rubric\Rubrics */

                $items[] = [
                    'label' => $rubric->name,
                    'url' => Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]),
                ];
            }

            echo Menu::widget([
                'options' => ['class' => 'header__navigation mainnavigation'],
                'items' => $items
            ]);
            ?>
            <!--header navigatoin end -->
            <!--header tools start -->
            <div class="header__tools clearfix">
                <div class="header__subscription opacity">
                    <a href="#" class="subscription clearfix" data-popup="subscribe">
                        <span href="#" class="subscription__icon">
                            <img src="/images/subscription.jpg" alt="subscription">
                        </span>
                        <span class="subscription__description">
                            <span class="subscription__action">Подписаться</span>
                            <span class="subscription__number"><?= $this->params['subscribers'];?> читателей</span>
                        </span>
                    </a>
                </div>
                <a href="#" class="header__search opacity" data-popup="search"></a>
            </div>
            <!--header tools end -->
            <?php if ($this->params['pageParams']['type'] == 'rubric'): ?>
                <!--header category start -->
                <div class="header__category clearfix">
                    <div class="header__title">
                        <?= $this->title; ?>
                    </div>
                    <div class="header__choice">
                        <a class="marked"><?= \Yii::$app->formatter->asDate(time(), 'php:M Y')?></a>
                        <a href="<?= Url::toRoute(['posts/authors']);?>" class="">Авторы</a>
                    </div>
                </div>
                <!--header category end -->
            <?php elseif ($this->params['pageParams']['type'] == 'post'): ?>
                <!--header intertal   start -->
                <div class="header__intertal">
                    <div class="header__title">
                        <span><?= $this->title; ?></span>
                    </div>
                </div>
                <!--header intertal   end -->
            <?php endif; ?>
        </div>
    </div>
</header>

<div class="mnt">
    <?= ArticleCarouselWidget::widget();?>
</div>