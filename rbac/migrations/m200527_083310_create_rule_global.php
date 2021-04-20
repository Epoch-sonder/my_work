<?php

use yii2mod\rbac\migrations\Migration;

class m200527_083310_create_rule_global extends Migration
{
    public function safeUp()
    {
	$this->createRule('global', 'Global rule');
    }

    public function safeDown()
    {
        echo "m200527_083310_create_rule_global cannot be reverted.\n";

        return false;
    }
}