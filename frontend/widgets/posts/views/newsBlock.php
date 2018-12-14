<?php
/* @var $posts array */
?>
<div  class="grid__block grid__selection cedition cedition__desctop">
    <div class="grid_border">
        <hr style="background: #222;">
    </div>

    <div class="center">
        <div class="row">
            <?php foreach ($posts as $type => $news): ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if ($news) {
                        echo $this->render("templates/_{$type}", [
                            'news' => $news['items'],
                            'title' => $news['title']
                        ]);
                    } ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>