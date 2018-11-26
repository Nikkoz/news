<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= \Yii::$app->language ?>">
    <head>
        <meta charset="<?= \Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php $this->registerCsrfMetaTags() ?>

        <title><?= Html::encode($this->title) ?></title>

        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrapper page_home">
            <?= $content;?>

            <?= $this->render('footer.php'); ?>
        </div>

        <!--menu start -->

        <div class="menu">
            <div class="menu__header">
                <div class="menu__logo"></div>
                <a href="#" class="menu__close"></a>
            </div>
            <div class="menu__box">
                <div class="menu__content">
                    <?= $this->render('menu_popup.php'); ?>
                    <ul class="menu__list">
                        <li><a href="#">О редакции</a></li>
                        <li><a href="#">Предложить сотрудничество</a></li>
                        <li><a href="#">Предложить новость</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="menu_substrate"></div>
        <!--menu end -->
        <!-- popups start -->
        <div class="popup__back popup__back-js"></div>
        <!-- popup search start -->
        <div class="popup__box search" role="search">
            <div class="popup__table popup__table-js">
                <div class="popup__tr popup__tr-js">
                    <div class="popup">
                        <div class="popup__header">
                            <a href="#" class="popup__close"></a>
                            <div class="popup__form">
                                <form action="#" class="form">
                                    <input type="text" class="input input_ui input_ui_search">
                                </form>
                            </div>
                        </div>
                        <div class="found__list">
                            <div class="found__overflow">
                                <div class="found">
                                    <div class="found__img">
                                        <img src="assets/media/band.jpg" alt="#">
                                    </div>
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                                <div class="found">
                                    <div class="found__content">
                                        <a href="#" class="found__title">Губернаторы отчитаются президенту Владимиру Путину о выполнении его указов</a>
                                        <div class="found__text">Квантовое состояние ненаблюдаемо. Излучение, при адиабатическом изменении параметров, мгновенно. Взрыв стохастично искажает квантовый магнит. Очевидно, что объект восстанавливает кварк</div>
                                        <div class="found__data">20 минут назад</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- popup search end-->
        <!-- popup subscribe start -->
        <div class="popup__box subscribe" role="subscribe">
            <div class="popup__table popup__table-js">
                <div class="popup__tr popup__tr-js">
                    <div class="popup">
                        <div class="popup__header">
                            <a href="#" class="popup__close"></a>
                            <div class="popup__form">
                                <form action="#" class="form">
                                    <div class="inputlabel">
                                        <label>
                                            <input type="text" class="input input_ui inputlabel__field">
                                            <span class="inputlabel__placeholder">
                             Ваш e-mail:
                           </span>
                                        </label>
                                        <label class="subscribe__agreement">
                                            <input type="checkbox" name="agreement">
                                            <span>Я выражаю согласие с <a href="http://mail.ru" target="_blank">условиями</a> обработки персональных данных</span>
                                        </label>
                                        <div  class="clearfix subscribe__footer">
                                            <button class="btn btn_big btn_brown btn_inline btn_compact subscribe__submit">ПОДПИСАТЬСЯ</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- popup subscribe  end-->
        <!-- popups end -->

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>