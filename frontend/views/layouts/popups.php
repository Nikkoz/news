<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;
?>
<!--menu start -->
<div class="menu">
    <div class="menu__header">
        <div class="menu__logo"></div>
        <a href="#" class="menu__close"></a>
    </div>
    <div class="menu__box">
        <div class="menu__content">
            <?= $this->render('menu_popup.php'); ?>
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
                        <form action="<?= Url::toRoute(['posts/search/index'])?>" class="form" method="get">
                            <input type="text" name="q" class="input input_ui input_ui_search" value="" />
                        </form>
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
                        <?php $form = ActiveForm::begin([
                            'id' => 'subscribe',
                            'action' => \yii\helpers\Url::to(['main/subscribe']),
                            'validationUrl' => \yii\helpers\Url::to(['main/subscribe-validate']),
                            'enableAjaxValidation' => true,
                            'options' => [
                                'class' => 'form',
                            ]
                        ]); ?>

                        <div class="inputlabel">
                            <?= $form->field($this->params['subscribeForm'], 'email', [
                                'template' => '<label>{input}<span class="inputlabel__placeholder">E-mail</span>{error}</label>'
                            ])->textInput([
                                'class' => 'input input_ui inputlabel__field'
                            ])->label(false);?>

                            <?= $form->field($this->params['subscribeForm'], 'agree', [
                                'template' => '<label class="subscribe__agreement">{input}<span>Я выражаю согласие с <a href="#" target="_blank">условиями</a> обработки персональных данных</span></label>'
                            ])->checkbox([], false)->label(false);?>

                            <div  class="clearfix subscribe__footer">
                                <?= \yii\helpers\Html::submitButton(\Yii::t('app', 'Subscribe'), ['class' => 'btn btn_big btn_brown btn_inline btn_compact subscribe__submit']) ?>
                            </div>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- popup subscribe  end-->
<!-- popups end -->