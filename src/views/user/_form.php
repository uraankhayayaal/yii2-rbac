<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Изменить пароль';
// $this->params['breadcrumbs'][] = $this->title;

?>

    <?php $form = ActiveForm::begin([
        'errorCssClass' => 'red-text',
    ]); ?>

    <?php
        $list = ArrayHelper::map(\backend\models\RoleForm::allAsArray(),'name','description');
        $setted_roles = \backend\models\AssignmentForm::getUserAssignments($user->id);
        $setted_values = ArrayHelper::map($setted_roles, 'roleName', 'userId');
        $security = new \yii\base\Security();
    ?>
    <div class="input-field">
        <input type="hidden" name ="<?= Html::getInputName($model, 'hash'); ?>" value="<?= $security->generateRandomString(); ?>">
        <select multiple name="<?= Html::getInputName($model, 'user_roles'); ?>[]">
            <option value="" disabled <?= empty($setted_roles) ? 'selected' : ''; ?> >Выберите</option>
            <?php foreach ($list as $key => $value) { ?>
                <option value="<?= $key ?>" <?= (array_key_exists($key, $setted_values)) ? 'selected' : ''; ?> ><?= $value ?></option>
            <?php } ?>
        </select>
        <label><?= $model->getAttributeLabel('user_roles'); ?></label>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
