<?php
/** @var $this \yii\web\View */
/** @var $data array */

use news\helpers\NewsHelper;
?>

<div class="important-minor clearfix">
    <p><?= NewsHelper::getTizer($data['tizer'])?></p>
    <?= $data['text']; ?>
</div>
