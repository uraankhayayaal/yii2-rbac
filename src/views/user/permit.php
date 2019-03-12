<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $user->username;
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-permit">
    <div class="row">
        <div class="col s12">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Назначение прав</p>

            <?= $this->render('_form', ['model' => $model, 'user' => $user]); ?>
        </div>
    </div>
</div>
