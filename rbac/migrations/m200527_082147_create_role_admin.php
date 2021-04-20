<?php

use yii2mod\rbac\migrations\Migration;

class m200527_082147_create_role_admin extends Migration
{
    public function safeUp()
    {
	$this->createRole('admin', 'admin has all available permissions.');
    }

    public function safeDown()
    {
        echo "m200527_082147_create_role_admin cannot be reverted.\n";

        return false;
    }
}