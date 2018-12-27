<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Teste3 */

$this->title = 'Create Teste3';
$this->params['breadcrumbs'][] = ['label' => 'Teste3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="teste3-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
