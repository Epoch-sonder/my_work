<?php

namespace app\modules\user\models;
use yii\base\Model;
 
class CreateRolePermission extends Model{
    
    public $permission;
	public $role_id;
	public $create;
	public $description;
	public $role_create;

    public function rules()
    {
        return [
            [['role_id', 'create'], 'required'],
            [['role_id', 'permission','role_create'], 'string'],
            [['create'], 'integer'],
            [['description'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [

            'permission' => 'Права доступа',
            'role_id' => 'Роль',
            'role_create' => 'Роль',
            'description' => 'Описание роли',
            'create' => 'Создание роли или добавление к ней разрешений',
        ];
    }
    
}