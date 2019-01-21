<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Qhiboard */

$this->title = 'Create Qhiboard';
$this->params['breadcrumbs'][] = ['label' => 'qhiboard', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="qhiboard-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
