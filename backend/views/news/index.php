<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\posts\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="box box-info">
            <div class="box-header">
                <div class="row">
                    <div class="col-md-4">
                        <?= Html::a(\Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <div class="box-body table__scroll">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'title',
                        'preview_text:ntext',
                        'hot_picture',
                        //'rectangle_picture',
                        //'square_picture',
                        //'analytic_picture',
                        //'is_analytic',
                        //'discussing',
                        //'reading',
                        //'choice',
                        //'publish',
                        //'sort',
                        //'created_at',
                        //'created_by',
                        //'updated_at',
                        //'updated_by',
                        ['class' => 'yii\grid\ActionColumn'],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>