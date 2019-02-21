<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ItemassuranceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Item Assurances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-assurance-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Item Assurance', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nome',
            'judge',
            'assurance',
            'situacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
