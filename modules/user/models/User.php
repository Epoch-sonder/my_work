<?php

namespace app\modules\user\models;

use Yii;

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

	public $authKey = '';

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

	public function validatePassword($password)
	{
		return Security::validatePassword($password, $this->password_hash);
	}
	
	public function setPassword($password)
	{
    $this->password_hash = Security::generatePasswordHash($password);
	}

    public function getAuthKey()
    {
        return;
    }

   public function validateAuthKey($authKey)
	{
		return;
	}

    public static function tableName()
    {
        return 'user';
    }

	public function signup()
{
    if ($this->validate()) {
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->save();
        return $user;
    }

    return null;
}

	public function beforeSave($insert) {
    if(isset($this->password_field)) 
        $this->password = Security::generatePasswordHash($this->password_field);
    return parent::beforeSave($insert);
}

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['branch_id', 'enabled'], 'integer'],
            [['username', 'password'], 'string', 'max' => 255],
            [['position', 'fio'], 'string', 'max' => 300],
            [['phone'], 'string', 'max' => 100],
            [['email'], 'email'],
            [['username'], 'unique'],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_id' => 'branch_id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Roles::className(), 'targetAttribute' => ['role_id' => 'role_id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'password' => 'Пароль',
            'role_id' => 'Права доступа',
            'branch.name' => 'Филиал',
            'branchName' => 'Филиал',
			'role.name' => 'Права доступа',
            'roleName' => 'Роль',
			'branch_id' => 'Филиал',
            'position' => 'Должность',
            'fio' => 'Имя сотрудника', //'ФИО',
            'phone' => 'Номер телефона',
            'email' => 'Электронная почта',
            'enabled' => 'Активен',
        ];
    }

    public function getBranch()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_id']);
    }

    public function getBranchName() {
        return $this->branch->name;
    }


    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['role_id' => 'role_id']);
    }

    public function getRoleName() {
        return $this->role->name;
    }


        public function getId()
    {
        return $this->id;
    }



}


