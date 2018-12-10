<?php

/** @var $this \yii\web\View */
/** @var $data array */

use news\helpers\NewsHelper;

$slider = NewsHelper::getSlider($data['slider']);
?>

<div class="minislider owl-carousel owl-mini">
    <?php foreach ($slider->picturesAssignments as $picture):
        /** @var $picture \news\entities\Pictures */
        ?>

        <div class="item">
            <div class="minislider__title"><?= $slider->name; ?></div>
            <div class="minislider__resource"><?= $slider->description; ?></div>
            <img src="<?= $picture->getImage()->getPicture(); ?>">
        </div>
    <?php endforeach; ?>
</div>
