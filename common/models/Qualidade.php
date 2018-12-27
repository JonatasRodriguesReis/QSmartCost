<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "qualidade".
 *
 * @property string $partNumber
 * @property string $partName
 * @property integer $status
 */
class Qualidade extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'qualidade';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['partNumber', 'partName', 'status'], 'required'],
            [['status'], 'integer'],
            [['partNumber'], 'string', 'max' => 100],
            [['partName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'partNumber' => 'Part Number',
            'partName' => 'Part Name',
            'status' => 'Status',
        ];
    }
}
