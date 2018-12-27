<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Teste3 */
/* @var $form ActiveForm */
?>
<div class="Teste">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'nome') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- Teste -->
