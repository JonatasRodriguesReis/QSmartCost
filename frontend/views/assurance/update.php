<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Assurance */

$this->title = 'Update Assurance: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="assurance-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
