<?php
/** @var $this \yii\web\View */
/** @var $data array */

use news\helpers\NewsHelper;

/** @var $video \news\entities\posts\video\Videos */
$video = NewsHelper::getVideo($data['video']);
?>
<div class="videoplay">
    <div class="videoplay__video">
        <div style="position:relative;height:0;padding-bottom:56.25%">
            <iframe src="<?= $video->link; ?>" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe>
        </div>
    </div>
    <div class="videoplay__back">
        <img src="<?= $video->picture->getPicture(); ?>" alt="<?= $video->name; ?>">
    </div>
    <div class="videoplay__description clearfix">
        <div class="videoplay__icon"></div>
        <div class="videoplay__title">
            <?= $video->name; ?>
        </div>
        <div class="videoplay__resource">Видео: <?= $video->site; ?></div>
    </div>
</div>
