<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "branch".
 *
 * @property int $branch_id
 * @property int|null $main_branch_id
 * @property string|null $name
 * @property string|null $full_name
 *
 * @property Contract[] $contracts
 * @property ForestWork[] $forestWorks
 * @property ForestWorkReporter[] $forestWorkReporters
 * @property ResponsibilityArea[] $responsibilityAreas
 * @property User[] $users
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
     * Gets query for [[Contracts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getContracts()
    {
        return $this->hasMany(Contract::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * Gets query for [[ForestWorks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestWorks()
    {
        return $this->hasMany(ForestWork::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * Gets query for [[ForestWorkReporters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForestWorkReporters()
    {
        return $this->hasMany(ForestWorkReporter::className(), ['reporter_branch' => 'branch_id']);
    }

    /**
     * Gets query for [[ResponsibilityAreas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponsibilityAreas()
    {
        return $this->hasMany(ResponsibilityArea::className(), ['branch_id' => 'branch_id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['branch_id' => 'branch_id']);
    }
}
