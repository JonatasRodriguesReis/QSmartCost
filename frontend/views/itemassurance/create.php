<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ItemAssurance */

$this->title = 'Create Item Assurance';
$this->params['breadcrumbs'][] = ['label' => 'Item Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-assurance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
