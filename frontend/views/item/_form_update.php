<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */

$script = <<< JS
  $(document).ready(function(){
        $('button').click(function(){
        	if ($(".table-responsive").length){ 
		        var texto_nome = $('#days-header').find('tbody tr:nth-child(1) td:nth-child(1)').data('nome');
	            var id = $('#days-header').find('tbody tr:nth-child(1) td:nth-child(1)').data('id');
	            var selValue = $('input[name=radios_' + texto_nome +']:checked').data('date'); 
	            var data_old = $('thead').data('date');
	            var comentario = $("#item-comentario").val();
	            $("#item-comentario").val("");

				data_arr = JSON.stringify({id: id ,data:selValue, data_old : data_old,item_comentario:comentario});
	            
	            $.ajax({
	                url: '?r=item/updatedata',
	                type: 'post',
	                datatype: 'json',
					contentType: "application/json; charset=utf-8",
	                data:data_arr,
	                error: function(xhr, ajaxOptions, thrownError){
	                	alert(thrownError);
	                }
	            });
		    }            
        });
    });
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
        if($model->situacao == "NÃO_REALIZADO"){
        	$html = '<div class="table-responsive">
        				<br>
				        <table id = "days-header" class="table  table-striped table-hover " style="width: 90%">'.
				        	$htm
				        .'</table>
    				</div>';
        	echo $html;
        }

     ?>

    

    <?= $form->field($model, 'comentario')->textarea(['rows' => '10'])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
