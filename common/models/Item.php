<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property string $nome
 * @property string $data_teste
 * @property string $situacao
 * @property int $statusrohs
 *
 * @property Statusrohs $statusrohs0
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'data_teste', 'situacao'], 'required'],
            [['comentario'], 'string', 'max' => 500],
            [['part_number'], 'string', 'max' => 50],
            [['judge'], 'string', 'max' => 10],
            [['data_teste'], 'safe'],
            [['statusrohs'], 'integer'],
            [['nome', 'situacao'], 'string', 'max' => 50],
            [['statusrohs'], 'exist', 'skipOnError' => true, 'targetClass' => Statusrohs::className(), 'targetAttribute' => ['statusrohs' => 'id']],
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
            'data_teste' => 'Data Teste',
            'situacao' => 'Situacao',
            'statusrohs' => 'Statusrohs',
            'comentario' => 'Comment',
            'part_number' => 'Part Number',
            'judge' => 'Judge',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatusrohs0()
    {
        return $this->hasOne(Statusrohs::className(), ['id' => 'statusrohs']);
    }
}
