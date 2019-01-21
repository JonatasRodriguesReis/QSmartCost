<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Assurance */

$this->title = 'Create Assurance';
$this->params['breadcrumbs'][] = ['label' => 'Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="assurance-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> >-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
