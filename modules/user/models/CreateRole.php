<?php

namespace app\modules\user\models;
use yii\base\Model;
 
class CreateRole extends Model{
    
    public $username;
	public $permission;
    
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['username'], 'integer'],
            [['permission'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'username' => 'Логин',
            'permission' => 'Права доступа',
        ];
    }
    
}