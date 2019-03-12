<?php

namespace ayaalkaplin\rbac\models;

use Yii;
use yii\base\Model;

class AssignmentForm extends Model
{
    public $user_roles;
	public $user_id;

	public function rules()
    {
    	return [
            [['user_id'], 'exist', 'targetClass' => \common\models\User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['user_roles'], 'each', 'rule' => ['string'], 'skipOnEmpty' => true],
    	];
    }

    public function attributeLabels()
    {
        return [
            'user_roles' => "Роли",
            'user_id' => "Пользователь",
        ];
    }

    static function getUserAssignments($userId)
    {
        $auth = Yii::$app->authManager;
        return $auth->getAssignments($userId);
    }

    public function updateAssignments()
    {
        if(!empty($this->user_roles))
        {
        	foreach ($this->user_roles as $key => $user_role) {
        		$auth = Yii::$app->authManager;
        		$isSeted = $auth->getAssignment($user_role, $this->user_id);
                if($isSeted === null){
        			$role = $auth->getRole($user_role);
        			$auth->assign($role, $this->user_id);
                }
            }

            Yii::$app->authManager->db->createCommand()
                ->delete(Yii::$app->authManager->assignmentTable, ['AND', 'user_id = :user_id', ['NOT IN', 'item_name', $this->user_roles]], [':user_id' => $this->user_id])
                ->execute();
        }else{
            $auth = Yii::$app->authManager;
            $auth->revokeAll($this->user_id);
        }
        
        return true;
    }
}
