<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $branch_id
 * @property int|null $main_branch_id
 * @property string|null $name
 * @property string|null $full_name
 *
 * @property AuditPerson[] $auditPeople
 */
class Branch extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branch';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id'], 'required'],
            [['branch_id', 'main_branch_id'], 'integer'],
            [['name', 'full_name'], 'string', 'max' => 255],
            [['branch_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'branch_id' => 'Branch ID',
            'main_branch_id' => 'Main Branch ID',
            'name' => 'Name',
            'full_name' => 'Full Name',
        ];
    }

    /**
     * Gets query for [[AuditPeople]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuditPeople()
    {
        return $this->hasMany(AuditPerson::className(), ['branch' => 'branch_id']);
    }
}
