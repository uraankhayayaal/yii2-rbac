<?php

namespace ayaalkaplin\rbac\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PermissionForm extends Model
{
    public $name;
    public $description;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Идентификатор",
            'description' => "Название",
        ];
    }

    public function all()
    {
        $auth = Yii::$app->authManager;

        $query = (new \yii\db\Query())->from($auth->itemTable)->where(['type' => \yii\rbac\Item::TYPE_PERMISSION]);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'description'],
            ],
        ]);

        $query->andFilterWhere(['like', 'name', Yii::$app->request->getQueryParam('filtername', '')])
            ->andFilterWhere(['like', 'description', Yii::$app->request->getQueryParam('filterdescription', '')]);

        return $dataProvider;
    }

    static function allRolesAndPermissions()
    {
        $auth = Yii::$app->authManager;

        $query = (new \yii\db\Query())->from($auth->itemTable);

        return $query->all();
    }

    public function save()
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->createPermission($this->name);
        $permission->description = $this->description;
        return $auth->add($permission);
    }

    public function update($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $permission->name = $this->name;
        $permission->description = $this->description;
        return $auth->update($name, $permission);
    }

    static function getPermit($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        $model = new self;
        $model->name = $permission->name;
        $model->description = $permission->description;
        return $model;
    }

    static function delete($name)
    {
        $auth = Yii::$app->authManager;
        $permission = $auth->getPermission($name);
        
        return $auth->remove($permission);
    }
}
