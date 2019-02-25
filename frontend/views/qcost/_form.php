<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Qcost */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="qcost-form">

    <?php $form = ActiveForm::begin(); ?>

    <?=$form->field($model, 'custo')->dropDownList([
	'Sales' => 'Sales', 
	'Repair' => 'Repair',
	'Return' => 'Return',
	'Scrap' => 'Scrap',
	'Nowork' => 'Nowork',
	'Rework' => 'Rework',
	'Line Repair' => 'Line Repair',
	], 
	['prompt'=>'', 'style'=>'width: 100%']
	); ?>
	
	<?=$form->field($model, 'modelo')->dropDownList([
	'RAC' => 'RAC', 
	'MWO' => 'MWO'
	], 
	['prompt'=>'', 'style'=>'width: 100%']
	); ?>

    <?= $form->field($model, 'data')->textInput() ?>

    <?= $form->field($model, 'valor')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Cadastrar' : 'Salvar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
