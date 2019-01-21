<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AssuranceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assurances';
$this->params['breadcrumbs'][] = $this->title;
?>
</br>
<div class="assurance-index">
        <div class="box box-danger container">
            <div class="box-header with-border">
            <br>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>

            <p>
                <?= Html::a('Gerar Plano', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            
            <div id="container">
            </div>
            
        </div>
</div>
