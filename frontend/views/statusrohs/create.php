<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\statusrohs */

$this->title = 'Create Statusrohs';
$this->params['breadcrumbs'][] = ['label' => 'Statusrohs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
</br>
<div class="statusrohs-create">

    <div class="box box-danger">
        <div class="box-header with-border">
			<br>
			<h1><?= Html::encode($this->title) ?></h1>
		</div>

	    <div class="container">
	    	<?= $this->render('_form', [
	        	'model' => $model,
	    	]) ?>
	    </div>
	 </div>

</div>
