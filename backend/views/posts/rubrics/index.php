<?php

use yii\helpers\Html;
use yii\grid\GridView;
use news\helpers\rubrics\RubricsHelper;
use news\entities\posts\rubric\Rubrics;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\RubricsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Rubrics');
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
                        ['attribute' => 'id', 'content' => function (Rubrics $model) {
                            return Html::a($model->id, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'name', 'content' => function (Rubrics $model) {
                            return Html::a(Html::encode($model->name), ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute'=>'color',
                            'format' => 'html',
                            'value' => function(Rubrics $model) {
                                return '<div class="show_color" style="background: '. $model->color .'"></div>';
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => RubricsHelper::statusList(),
                            'content' => function (Rubrics $model) {
                                return RubricsHelper::statusLabel($model->status, $model->id);
                            },
                            'format' => 'raw',
                        ],
                        'sort',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
