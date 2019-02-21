<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item_assurance".
 *
 * @property int $id
 * @property string $nome
 * @property string $judge
 * @property int $assurance
 * @property string $situacao
 *
 * @property Assurance $assurance0
 * @property SubitemAssurance[] $subitemAssurances
 */
class ItemAssurance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_assurance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['assurance'], 'integer'],
            [['nome'], 'string', 'max' => 50],
            [['judge'], 'string', 'max' => 10],
            [['situacao'], 'string', 'max' => 30],
            [['assurance'], 'exist', 'skipOnError' => true, 'targetClass' => Assurance::className(), 'targetAttribute' => ['assurance' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'judge' => 'Judge',
            'assurance' => 'Assurance',
            'situacao' => 'Situacao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssurance0()
    {
        return $this->hasOne(Assurance::className(), ['id' => 'assurance']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubitemAssurances()
    {
        return $this->hasMany(SubitemAssurance::className(), ['item_assurance' => 'id']);
    }
}
