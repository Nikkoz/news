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

            <div class="wrapper <?= $this->params['pageParams']['wrapper'];?>">
                <?= $content;?>

                <?= $this->render('inner/footer.php'); ?>
            </div>

            <?= $this->render('popups.php'); ?>

            <?php $this->endBody() ?>
        </body>
    </html>
<?php $this->endPage() ?>