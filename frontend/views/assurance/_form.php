<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Assurance */
/* @var $form yii\widgets\ActiveForm */
?>
<br>
<div class="assurance-form">

    <!--<?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'month')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?> -->

    <div class="box box-danger container">
            <div class="box-header with-border">
	            <br>
	                <h1>Gerar novo Plano para Assurance Teste</h1>
            </div>

            <form>
			  <div class="form-group col-sm-3">
			    <label for="month">Mês do plano</label>
			    <input type="text" class="form-control " id="month" placeholder="Mês">
			  </div>
			  
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
    </div>

</div>
