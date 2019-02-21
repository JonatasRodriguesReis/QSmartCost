<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ItemAssurance */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-assurance-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'judge')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'assurance')->textInput() ?>

    <?= $form->field($model, 'situacao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
