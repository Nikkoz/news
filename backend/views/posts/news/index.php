<?php

use yii\helpers\Html;
use yii\grid\GridView;
use news\entities\posts\News;
use news\helpers\NewsHelper;
use news\helpers\RubricsHelper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\posts\NewsSearch */
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
                        <?= Html::a(\Yii::t('app', 'Create'), ['news/create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
            <div class="box-body table__scroll">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        //['class' => 'yii\grid\CheckboxColumn'],
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'content' => function (News $model) {
                            return Html::a($model->id, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'title', 'content' => function (News $model) {
                            return Html::a(Html::encode($model->title), ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'preview_text', 'content' => function (News $model) {
                            return \Yii::$app->formatter->asHtml($model->preview_text);
                        }],
                        [
                            'attribute' => 'rubrics',
                            'filter' => RubricsHelper::rubricList(),
                            'content' => function (News $model) {
                                return RubricsHelper::rubricsLabels(\array_map(function($assignment) {
                                    return ArrayHelper::getValue($assignment, 'rubric_id');
                                }, $model->rubricAssignments));
                            }
                        ],
                        [
                            'attribute' => 'analytic',
                            'contentOptions' => ['class' => 'td-center td-green'],
                            'filter' => [1 => \Yii::t('app', 'Yes')],
                            'content' => function (News $model) {
                                return $model->analytic ? Html::tag('i', '', ['class' => 'fa fa-fw fa-check']) : '';
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => NewsHelper::statusList(),
                            'content' => function (News $model) {
                                return NewsHelper::statusLabel($model->status, $model->id);
                            },
                            'format' => 'raw',
                        ],
                        'sort',
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}'
                        ],
                    ]
                ]); ?>
            </div>
        </div>
    </div>
</div>
