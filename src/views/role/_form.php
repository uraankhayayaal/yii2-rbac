<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\modules\blog\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="role-form">

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <p><?= $model->getAttributeLabel('permissions'); ?></p>
    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Access</th>
                <th>Name</th>
            </tr>
        </thead>
        <thead>
        <?php foreach (\ayaalkaplin\rbac\models\PermissionForm::allRolesAndPermissions() as $key => $permission) { ?>
        <tr>
            <td>
                <?= ($permission['type'] == \yii\rbac\Item::TYPE_PERMISSION ? 'Permission' : ($permission['type'] == \yii\rbac\Item::TYPE_ROLE ? 'Role' : 'Another')); ?>
            </td>
            <td>
                <p class="switch">
                    <label>
                        Deny
                        <input type="checkbox" name="<?= Html::getInputName($model, 'children'); ?>[<?= $permission['name'] ?>]" <?= $model->hasChild($model->name, $permission) ? 'checked' : ''; ?>>
                        <span class="lever"></span>
                        Allow
                    </label>
                </p>
            </td>
            <td>
                <?= $permission['description'] ?>
            </td>
        </tr>
        <?php } ?>
        </thead>
    </table>
    <br>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']) ?>
    </div>
    <div class="fixed-action-btn">
        <?= Html::submitButton('<i class="material-icons">save</i>', [
            'class' => 'btn-floating btn-large waves-effect waves-light tooltipped',
            'title' => 'Сохранить',
            'data-position' => "left",
            'data-tooltip' => "Сохранить",
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
