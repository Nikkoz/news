<?php
/** @var $this \yii\web\View */
/** @var $class string */
?>
<header class="header <?= $class; ?>">
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
            <?= $this->render('/layouts/menu.php');?>
            <!--header navigatoin end -->

            <!--header tools start -->
            <div class="header__tools clearfix">
                <div class="header__subscription opacity">
                    <a href="#" class="subscription clearfix" data-popup="subscribe">
                        <span class="subscription__icon">
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
        </div>
    </div>
</header>