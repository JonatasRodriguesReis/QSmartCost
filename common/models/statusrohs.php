<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "statusrohs".
 *
 * @property int $id
 * @property string $month
 */
class statusrohs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'statusrohs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['month'], 'required'],
            [['month'], 'string', 'max' => 10],
			[['status'], 'string', 'max' => 15],
            [['reason'], 'string', 'max' => 500]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'month' => 'Month',
			'status'=>'Status',
            'reason'=>'Reason'
        ];
    }
}
