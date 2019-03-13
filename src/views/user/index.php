<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="row">
        <div class="col s12">

            <?= GridView::widget([
                'tableOptions' => [
                    'class' => 'striped bordered my-responsive-table',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                    ['class' => 'yii\grid\SerialColumn'],
                    ['class' => 'ayaalkaplin\materializecomponents\grid\MaterialActionColumn',
                        'template' => '{view}{permit}',
                        'buttons' =>
                        [
                            'permit' => function ($url, $model) {
                                return Html::a('<i class="material-icons">build</i>', Url::to(['user/permit', 'id' => $model->id]), [
                                    'title' => Yii::t('yii', 'Change user role')
                                ]); },
                        ]
                    ],

                    'username',
                    'email:email',
                    [
                        'header' => 'Роли и права',
                        'format' => 'raw',
                        'value' => function($model){
                            $permissionsAndRoles = '<p>Роли</p>';
                            foreach (\ayaalkaplin\rbac\models\RoleForm::getUserRoles($model->id) as $key => $permission) {
                                $permissionsAndRoles .= '<div class="chip">'.$permission->description.'</div>';
                            }
                            $permissionsAndRoles .= '<p>Права</p>';
                            foreach (\ayaalkaplin\rbac\models\RoleForm::getUserPermissions($model->id) as $key => $permission) {
                                $permissionsAndRoles .= '<div class="chip">'.$permission->description.'</div>';
                            }
                            return $permissionsAndRoles;
                        }
                    ],
                    [
                        'attribute' => 'created_at',
                        'format' => 'datetime',
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
