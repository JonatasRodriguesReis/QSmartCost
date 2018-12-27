<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\statusrohs */

$this->title = 'Update Statusrohs: ' . $model->month;
$this->params['breadcrumbs'][] = ['label' => 'StatusRoHS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->month, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<br>
<div class="statusrohs-update">

    <div class="box box-danger container">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

	    <?= $this->render('_form-update', [
	        'model' => $model,
	    ]) ?>
	</div>

</div>
