<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "subitem".
 *
 * @property int $id
 * @property string $nome
 * @property string $data_teste
 * @property int $item
 *
 * @property Item $item0
 */
class Subitem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subitem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'data_teste', 'item'], 'required'],
            [['data_teste'], 'safe'],
            [['item'], 'integer'],
            [['nome'], 'string', 'max' => 30],
            [['item'], 'exist', 'skipOnError' => true, 'targetClass' => Item::className(), 'targetAttribute' => ['item' => 'id']],
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
            'item' => 'Item',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItem0()
    {
        return $this->hasOne(Item::className(), ['id' => 'item']);
    }
}
