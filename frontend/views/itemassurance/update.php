<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ItemAssurance */

$this->title = 'Update Item Assurance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Item Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="item-assurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
