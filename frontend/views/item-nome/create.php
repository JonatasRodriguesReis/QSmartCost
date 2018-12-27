<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ItemNome */

$this->title = 'Create Item Nome';
$this->params['breadcrumbs'][] = ['label' => 'Item Nomes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-nome-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
