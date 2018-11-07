<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Item */

$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<br>
<div class="item-view">

    <div class="box box-danger container">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <!-- <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?> -->
        </p>

        <div class="table-responsive">
            <input type="button" id="gerar_dias" value="Click" style="display: none;"> 
            <br>
            <table id="days-header" class="table  table-striped table-hover "><thead style="background-color:#b71c1c;color:#fff">

                <?php //echo $teste?>
            </table>
        </div>

        <?php if($model->situacao == 'NÃO_REALIZADO' && $model->comentario != ''){
                echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'comentario'
                ],
              ]);
            }
            /*else{
                echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'status',
                        'contentOptions' => ['style' => 'color:' . 
                            ($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))],
                    ],
                ],
              ]);
            }*/
        ?>
    </div>
</div>
