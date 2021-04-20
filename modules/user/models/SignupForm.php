<?php

namespace app\modules\user\models;
use yii\base\Model;
 
class SignupForm extends Model{
    
    public $username;
    public $password;
    public $branch_id;
    public $position;
    public $fio;
    public $phone;
    public $email;
	public $enabled;
	public $role_id;
    
    public function rules()
    {
        return [
            [['username', 'password','role_id'], 'required'],
            [['branch_id', 'enabled'], 'integer'],
            [['username', 'password'], 'string', 'max' => 255],
            [['position', 'fio'], 'string', 'max' => 300],
            [['phone'], 'string', 'max' => 100],
            [['email'], 'required'],
            //[['username'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'branch_id' => 'Филиал',
            'position' => 'Должность',
            'role_id' => 'Права доступа',
            'fio' => 'ФИО',
            'phone' => 'Номер телефона',
            'email' => 'Электронная почта',
            'enabled' => 'Активация',
        ];
    }

	 public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }

    
}