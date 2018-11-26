<?php

use yii\helpers\Html;
use yii\grid\GridView;
use news\entities\posts\rubric\templates\RubricPositions;
use news\helpers\rubrics\RubricsHelper;
use news\helpers\rubrics\TemplateHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\RubricPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app', 'Rubric position');
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
                        ['attribute' => 'id', 'content' => function (RubricPositions $model) {
                            return Html::a($model->id, ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute' => 'rubric_id',
                            'filter' => RubricsHelper::rubricList(),
                            'content' => function (RubricPositions $model) {
                                return $model->rubricAssignment->name;
                            }
                        ],
                        [
                            'attribute' => 'template_id',
                            'filter' => TemplateHelper::templateList(),
                            'content' => function (RubricPositions $model) {
                                return $model->templateAssignment->name;
                            }
                        ],
                        'position',
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