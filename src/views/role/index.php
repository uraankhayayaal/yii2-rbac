<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Роли';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-index">
    <div class="row">
        <div class="col s12">
            <p>
                <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="fixed-action-btn">
                <?= Html::a('<i class="material-icons">add</i>', ['create'], [
                    'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
                    'title' => 'Сохранить',
                    'data-position' => "left",
                    'data-tooltip' => "Добавить",
                ]) ?>
            </div>
            
            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'striped bordered my-responsive-table',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['class' => 'ayaalkaplin\materializecomponents\grid\MaterialActionColumn', 'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<i class="material-icons">edit</i>', ['update', 'name' => $model['name']], [
                                    'title' => "Редактировать",
                                    'aria-label' => "Редактировать",
                                    'data-pjax' => "0",
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="material-icons">delete</i>', ['delete', 'name' => $model['name']], [
                                    'title' => "Удалить",
                                    'aria-label' => "Удалить",
                                    'data-pjax' => "0",
                                    'data-confirm' => "Вы уверены, что хотите удалить этот элемент?",
                                    'data-method' => "post",
                                ]);
                            },
                        ],
                    ],
                    [
                        'attribute' => 'name',
                        'format' => 'raw',
                        'value' => function($model){
                            return Html::a($model['name'],['update', 'name' => $model['name']]);
                        },
                        'filter' => '<input class="form-control" name="filtername" value="'. $searchModel['name'] .'" type="text">',
                    ],
                    [
                        'attribute' => 'description',
                        'filter' => '<input class="form-control" name="filterdescription" value="'. $searchModel['description'] .'" type="text">',
                    ],
                    [
                        'header' => 'Разрешенные права',
                        'format' => 'raw',
                        'value' => function($model){
                            $permissionsAndRoles = '<p>Права</p>';
                            foreach (\backend\models\RoleForm::getRolePermissions($model['name']) as $key => $permission) {
                                $permissionsAndRoles .= '<div class="chip">'.$permission->description.'</div>';
                            }
                            $permissionsAndRoles .= '<p>Дочерние роли</p>';
                            foreach (\backend\models\RoleForm::getChildRoles($model['name']) as $key => $roles) {
                                $permissionsAndRoles .= '<div class="chip">'.$roles->description.'</div>';
                            }
                            return $permissionsAndRoles;
                        },
                    ],
                ],
                'pager' => [
                    'class' => 'yii\widgets\LinkPager',
                    'options' => ['class' => 'pagination center'],
                    'prevPageCssClass' => '',
                    'nextPageCssClass' => '',
                    'pageCssClass' => 'waves-effect',
                    'nextPageLabel' => '<i class="material-icons">chevron_right</i>',
                    'prevPageLabel' => '<i class="material-icons">chevron_left</i>',
                ],
            ]); ?>

        </div>
    </div>
</div>
