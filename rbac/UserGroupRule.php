<?php
namespace app\rbac;
 
use Yii;
use yii\rbac\Rule;
 
class UserGroupRule extends Rule
{
    public $name = 'UserGroup';
 
    public function execute($user, $item, $params)
    {
        if (!\Yii::$app->user->isGuest) {
            $group = \Yii::$app->user->identity->group;
            if ($item->name === 'admin') {
                return $group == 'admin';
            } elseif ($item->name === 'superuser') {
                return $group == 'admin' || $group == 'superuser';
            } elseif ($item->name === 'superviser') {
                return $group == 'admin' || $group == 'superviser';
            } 
			elseif ($item->name === 'user') {
                return $group == 'admin' || $group == 'user';
            }
			elseif ($item->name === 'guest') {
                return $group == 'admin' || $group == 'guest';
            }
        }
        return true;
    }
}