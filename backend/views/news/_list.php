<?php

/* @var $this yii\web\View */
/* @var $model common\models\posts\News */

if(!empty($model)) :
    foreach($model as $news) : ?>
    <div class="news" data-id="<?= $news->id;?>">
        <div>
            <div class="slider-name"><?= $news->title;?></div>
        </div>
    </div>
<?php endforeach;
else: ?>
    <p>Список новостей пуст</p>
<?php endif;
