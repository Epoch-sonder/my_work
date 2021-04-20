<?php

namespace app\models;

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

    public function getId()
    {
        return $this->id;
    }

	public static function findByUsername($username)
	{
		return static::findOne(['username' => $username]);
	
	}
	public function validatePassword($password)
	{
		return \Yii::$app->security->validatePassword($password, $this->password);
	}

    public function getAuthKey()
    {
        return;
    }

   public function validateAuthKey($authKey)
	{
		return;
	}
}
