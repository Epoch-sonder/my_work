<?php

namespace app\models;
use yii\base\Model;
 
class SignupForm extends Model{
    
    public $username;
    public $password;
    public $branch_id;
    public $position;
    public $fio;
    public $phone;
    
    public function rules() {
        return [
            [['username', 'password', 'branch_id', 'position', 'fio', 'phone' ], 'required', 'message' => 'Заполните поле'],
			['username', 'unique', 'targetClass' => User::className(),  'message' => 'Этот логин уже занят'],
        ];
    }
    
    public function attributeLabels() {
        return [
            'username' => 'Логин',
            'password' => 'Пароль',
            'branch_id' => 'Номер филиала',
            'position' => 'Должность',
			'fio' => 'Фамилия И.О.',
			'phone' => 'Телефон',
			
        ];
    }
    
}