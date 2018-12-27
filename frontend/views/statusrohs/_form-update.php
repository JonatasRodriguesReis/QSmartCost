<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\statusrohs */
/* @var $form yii\widgets\ActiveForm */

/*<?= $form->field($model, 'status')->textInput(['maxlength' => true]);?>*/

$script = <<< JS

  $(document).ready(function(){

  		 $('#texto-motivo').hide();

         $('#statusrohs-status').change(function(){
              if($('#statusrohs-status option:selected').val() == 'NG'){
                $('#texto-motivo').show();
              }else{
              	$('#texto-motivo').hide();
              }

        });
    });

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>

<div class="statusrohs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'month')->textInput(['maxlength' => true]);?>
	
	
	
	<?= ($model->status === 'APPROVED')? ($form->field($model, 'status')->dropdownList(['PENDING'=>'PENDING','NG'=>'NG'], ['prompt' => $model->status])):
		($model->status == 'PENDING'? ($form->field($model, 'status')->dropdownList(['APPROVED'=>'APPROVED','NG'=>'NG'], ['prompt' => $model->status])):
		($form->field($model, 'status')->dropdownList(['APPROVED'=>'APPROVED','PENDING'=>'PENDING'], ['prompt' => $model->status])))?>
	
	<?= ($model->status === '')?($form->field($model, 'status')->dropdownList(['APPROVED'=>'APPROVED','PENDING'=>'PENDING','NG'=>'NG'], ['prompt' => $model->status])):''?>

	
	<div id = "texto-motivo">
		<div class="form-group">

			<?= $form->field($model, 'reason')->textarea(['rows' => '10']) ?>
	
		</div>
	</div>


    <div class="form-group">
        <?= 
		
		Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
