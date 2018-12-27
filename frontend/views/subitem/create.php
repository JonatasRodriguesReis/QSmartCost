<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Subitem */

$this->title = 'Create Subitem';
$this->params['breadcrumbs'][] = ['label' => 'Subitems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subitem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
