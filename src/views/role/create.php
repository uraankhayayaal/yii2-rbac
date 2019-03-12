<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\blog\models\Article */

$this->title = 'Новая роль';
// $this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-create">
    <div class="row">
        <div class="col s12">
		    <?= $this->render('_form', [
		        'model' => $model,
		    ]) ?>
        </div>
    </div>
</div>
