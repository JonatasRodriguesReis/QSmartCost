<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "assurance".
 *
 * @property int $id
 * @property string $month
 */
class Assurance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'assurance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plan' => 'Plano',
        ];
    }
}
