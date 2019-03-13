<?php

namespace ayaalkaplin\rbac\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;
use yii\rbac\Item;

/**
 * ContactForm is the model behind the contact form.
 */
class RoleForm extends Model
{
    public $name;
    public $description;

    public $children;

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'description'], 'string'],
            ['children', 'each', 'rule' => ['string'], 'skipOnEmpty' => true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => "Идентификатор",
            'description' => "Название",
            'children' => "Доступ",
        ];
    }

    static function all()
    {
        $auth = Yii::$app->authManager;

        $query = (new Query())->from($auth->itemTable)->where(['type' => Item::TYPE_ROLE]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'description'],
            ],
        ]);

        $query->andFilterWhere(['like', 'name', Yii::$app->request->getQueryParam('filtername', '')])
            ->andFilterWhere(['like', 'description', Yii::$app->request->getQueryParam('filterdescription', '')]);
            
        return $dataProvider;
    }

    static function allAsArray()
    {
        $auth = Yii::$app->authManager;
        return $auth->getRoles();
    }

    static function getRolePermissions($name)
    {
        $auth = Yii::$app->authManager;
        return $auth->getPermissionsByRole($name);
    }

    static function getChildRoles($roleName)
    {
        $auth = Yii::$app->authManager;
        return $auth->getChildRoles($roleName);
    }

    static function getUserPermissions($userId)
    {
        $auth = Yii::$app->authManager;
        return $auth->getPermissionsByUser($userId);
    }

    static function getUserRoles($userId)
    {
        $auth = Yii::$app->authManager;
        return $auth->getRolesByUser($userId);
    }

    public function save()
    {
        $auth = Yii::$app->authManager;
        $role = $auth->createRole($this->name);
        $role->description = $this->description;
        $auth->add($role);
        return $this->updateChildren();
    }

    public function update($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $role->name = $this->name;
        $role->description = $this->description;
        $auth->update($name, $role);
        return $this->updateChildren();
    }

    static function getPermit($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $model = new self;
        $model->name = $role->name;
        $model->description = $role->description;
        return $model;
    }

    static function delete($name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        
        return $auth->remove($role);
    }




    public function addChild($parent_name, $child_name){
        $auth = Yii::$app->authManager;
        $parent = $this->getItem($parent_name);
        $child = $this->getItem($child_name);
        return $auth->addChild($parent, $child);
    }
    public function removeChild($parent_name, $child_name){
        $auth = Yii::$app->authManager;
        $parent = $this->getItem($parent_name);
        $child = $this->getItem($child_name);
        return $auth->removeChild($parent, $child);
    }
    public function removeChildren($parent_name){
        $auth = Yii::$app->authManager;
        $parent = $this->getItem($parent_name);
        return $auth->removeChildren($parent);
    }
    public function hasChild($parent_name, $child_name){
        $auth = Yii::$app->authManager;
        $parent = $this->getItem($parent_name);
        $child = $this->getItem($child_name);
        return $auth->hasChild($parent, $child);
    }
    public function getChildren($name){
        $auth = Yii::$app->authManager;
        $child = $this->getItem($name);
        return $auth->getChildren($name);
    }

    public function getItem($name){
        $auth = Yii::$app->authManager;
        $item = $auth->getRole($name);
        if($item !== null){
            return $item;
        }else{
            return $auth->getPermission($name);
        }
    }

    public function updateChildren(){
        if($this->children !== null){
            $children = $this->getChildren($this->name);
            foreach ($children as $key => $child) { 
                if(!array_key_exists($child->name, $this->children)){
                    $this->removeChild($this->name, $child->name);
                }
            }
            
            foreach ($this->children as $key => $child) {
                $isSeted = $this->hasChild($this->name, $key);
                if(!$isSeted){
                    $this->addChild($this->name, $key);
                }
            }
        }else{
            return $this->removeChildren($this->name);
        }
        return true;
    }
}
