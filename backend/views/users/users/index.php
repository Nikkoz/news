<?php

use yii\helpers\Html;
use yii\grid\GridView;
use news\helpers\UsersHelper;
use news\entities\user\User;

/* @var $this yii\web\View */
/* @var $searchModel \backend\forms\UserSearch */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = ['label' => $this->title];
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
                        ['attribute' => 'id', 'content' => function(User $model) {
                            return Html::a($model->id, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'name', 'content' => function(User $model) {
                            return Html::a($model->name, ['update', 'id' => $model->id]);
                        }],
                        ['attribute' => 'email', 'content' => function(User $model) {
                            return Html::a($model->email, ['update', 'id' => $model->id]);
                        }],
                        [
                            'attribute' => 'role',
                            'label' => \Yii::t('app', 'Role'),
                            'filter' => UsersHelper::getRoleList(),
                            'content' => function(User $model) {
                                return UsersHelper::getRole($model->id);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'filter' => UsersHelper::statusList(),
                            'content' => function(User $model) {
                                return \Yii::$app->user->id != $model->id ? UsersHelper::statusLabel($model->status, $model->id) : UsersHelper::statusLabelNotChange($model->status);
                            }
                        ],
                        'last_auth:datetime',
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

