<?php

namespace app\modules\audit\models;

use Yii;

/**
 * This is the model class for table "audit_type".
 *
 * @property int $id
 * @property string $type
 *
 * @property Audit[] $audits
 */
class AuditType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'audit_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип проверки',
        ];
    }

    /**
     * Gets query for [[Audits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAudits()
    {
        return $this->hasMany(Audit::className(), ['audit_type' => 'id']);
    }
}
