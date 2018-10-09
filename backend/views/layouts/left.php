<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => \Yii::$app->user->isGuest],
                    [
                        'label' => \Yii::t('app', 'News'),
                        'url' => '#',
                        'icon' => 'newspaper',
                        'items' => [
                            ['label' => \Yii::t('app', 'Articles'), 'icon' => 'newspaper', 'url' => \yii\helpers\Url::toRoute(['/news']), 'active' => $this->context->id == 'posts/news'],
                            ['label' => \Yii::t('app', 'Rubrics'), 'icon' => 'cubes', 'url' => \yii\helpers\Url::toRoute(['/rubrics']), 'active' => $this->context->id == 'posts/rubrics'],
                        ],
                    ],
                    [
                        'label' => 'Development',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>
    </section>
</aside>
