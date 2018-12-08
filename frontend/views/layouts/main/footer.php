<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Menu;
?>
<footer class="footer">
    <div class="center">
        <div class="footer__top clearfix">
            <div class="footer__subscription">
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
            <div class="footer__social">
                <a href="#" target="_blank" class="socialbutton-facebook"></a>
                <a href="#" target="_blank" class="socialbutton-vk"></a>
                <a href="#" target="_blank" class="socialbutton-ok"></a>
                <a href="#" target="_blank" class="socialbutton-inst"></a>
            </div>
            <div class="footer__logocenter">
                <a href="/" class="footer__logo"></a>
            </div>
        </div>
        <div class="footer__menus clearfix">
            <?php
            $items[] = [
                'label' => \Yii::t('app', 'News'),
                'url' => Url::toRoute(['posts/rubrics/index', 'rubric' => 'news'])
            ];

            foreach ($this->params['rubrics'] as $rubric) {
                $items[] = [
                    'label' => $rubric->name,
                    'url' => Url::toRoute(['posts/rubrics/index', 'rubric' => $rubric->slug]),
                ];
            }

            echo Menu::widget([
                'options' => ['class' => 'footer__navigation mainnavigation'],
                'items' => $items
            ]);

            echo Menu::widget([
                'options' => ['class' => 'footer__submenu mainnavigation'],
                'items' => [
                    [
                        'label' => \Yii::t('app', 'About'),
                        'url' => Url::toRoute(['site/about']),
                    ], [
                        'label' => \Yii::t('app', 'Offer cooperation'),
                        'url' => Url::toRoute(['site/cooperation']),
                    ], [
                        'label' => \Yii::t('app', 'Suggest News'),
                        'url' => Url::toRoute(['site/suggest']),
                    ],
                ]
            ]); ?>
        </div>
        <div class="footer__bottom clearfix">
            <div class="footer__copy">
                © <?= date('Y'); ?>. <?= Html::encode(\Yii::$app->name) ?>.
            </div>
        </div>
    </div>
</footer>