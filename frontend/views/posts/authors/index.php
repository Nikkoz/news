<?php
/** @var $this \yii\web\View */
/** @var $authors \news\entities\user\User[] */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Наши авторы';
?>
<div class="center">
    <div class="autors">
        <h1 class="h1">Наши авторы</h1>
        <div class="autors__list clearfix">
            <div class="row">
                <?php foreach ($authors as $author): ?>
                    <div class="col-xs-12 col-xxsm-12 col-xsm-6 col-sm-6 col-md-4 col-lg-4">
                        <a class="autors__item clearfix" href="<?= Url::toRoute(['posts/authors/detail', 'id' => $author->id]);?>">
                            <div class="autors__img">
                                <img src="<?= $author->getPhotoMin('64x64');?>" alt="<?= Html::encode($author->getFullName());?>">
                            </div>
                            <div class="autors__description">
                                <div class="autors__name">
                                    <?= Html::encode($author->getFullName());?>
                                </div>
                                <div class="autors__articles">
                                    <?= $author->getCountPosts();?> статей
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
