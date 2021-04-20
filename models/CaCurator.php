<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ca_curator".
 *
 * @property int $id
 * @property int $branch_kod id филиала РЛИ
 * @property int $person_kod id пользователя
 * @property int|null $comment примечания
 *
 * @property Branch $branchKod
 * @property User $personKod
 */
class CaCurator extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ca_curator';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_kod', 'person_kod'], 'required'],
            [['branch_kod', 'person_kod', 'comment'], 'integer'],
            [['branch_kod'], 'exist', 'skipOnError' => true, 'targetClass' => Branch::className(), 'targetAttribute' => ['branch_kod' => 'branch_id']],
            [['person_kod'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['person_kod' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_kod' => 'Филиал',
            'branchName' => 'Филиал',
            'person_kod' => 'Куратор',
            'personName' => 'Куратор',
            'comment' => 'Примечания',
        ];
    }

    /**
     * Gets query for [[BranchKod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranchKod()
    {
        return $this->hasOne(Branch::className(), ['branch_id' => 'branch_kod']);
    }

    public function getBranchName()
    {
        return $this->branchKod->name;
    }

    /**
     * Gets query for [[PersonKod]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPersonKod()
    {
        return $this->hasOne(User::className(), ['id' => 'person_kod']);
    }
    public function getPersonName()
    {
        return $this->personKod->fio;
    }

}
