<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Load */

$this->title = $model->item ." - ". $model->item_name;
$this->params['breadcrumbs'][] = ['label' => 'Inspections', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->item;
?>

<br>
<div class="load-view">
<div class="box box-danger">

            <div class="box-header with-border">
				<div class="col-md-6">
					<h1><?= Html::encode($this->title) ?></h1>
				</div>
				<div class="col-md-6" align="right">
					<!--<button type="button" class="btn btn-success" style="border-radius: 10px" onclick="document.getElementById('id01').style.display='block'" >Cálculo de Resistência</button>-->
					<a target="_blank" href=<?php echo Url::to('?r=qualidade/view&id=' . $model->item) ?> >
						<button type="button" class="btn btn-warning" style="border-radius: 10px">Digital History Card</button>
					</a>
					<!--<a target="_blank" href="http://10.193.236.94:85/QSmart/advanced/frontend/web/index.php?r=qualidade%2Fview&id=<?= $model->item ?>">
						<button type="button" class="btn btn-warning" style="border-radius: 10px">Digital History Card</button>
					</a>-->
				</div>
			</div>
			
			<!--
			<div id="id01" class="w3-modal">
				<div class="w3-modal-content w3-animate-zoom w3-card-4">
				  <header class="w3-container w3-teal"> 
					<span onclick="document.getElementById('id01').style.display='none'" 
					class="w3-button w3-display-topright">&times;</span>
					<h2>Cálculo da Resistência do Motor AC</h2>
				  </header>
				  <div class="w3-container">
					<br>
					<input id="tempReferencia" class="form-control input-lg" type="text" placeholder="Temperatura de referência °C">
					<br>
					<input id="tempEncontrada" class="form-control input-lg" type="text" placeholder="Temperatura encontrada °C">
					<br>
					<input id="resistencia" class="form-control input-lg" type="text" placeholder="Resistência medida">
					<br>
					<h3>RESULTADO: </h3>
					<p align="right">
						<button type="button" class="btn btn-success" style="border-radius: 10px">Calcular!</button>
					</p>
				  </div>
				</div>
		  </div>
			-->
		<?php
		if ($model->fim_inspecao != NULL){
			$data1 = new DateTime($model->fim_inspecao);
			$data2 = new DateTime($model->inicio_inspecao);
			$intervalo = $data1->diff( $data2 );
			$hora = $intervalo->h*3600;
			$min = $intervalo->i*60;
			$seg = $intervalo->s;
			
			$model->tempo_inspecao = $hora + $min + $seg;
			$model->save();
			$model->tempo_inspecao = "{$intervalo->h} hora(s) {$intervalo->i} minuto(s) e {$intervalo->s} segundo(s)";
		}
		?>
    <!--
	<p>
        <?= Html::a('Update', ['update', 'id' => $model->asn], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->asn], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
	-->
	 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'asn',
            'item',
            'item_name',
            'receipt_qty',
            'departure_date',
            'receipt_date',
            'iqc_received',
            'inicio_inspecao',
            'fim_inspecao',
            'status',
			//'judgement_date'
            'inspetor_iqc',
			'tempo_inspecao',
        ],
    ]) ?>
	
	<?php
		if(($model->status == "TO DO" or $model->status == "to do") && $model->iqc_received != NULL){
			echo Html::a('Iniciar Inspeção', ['start', 'id' => $model->asn], ['class' => 'btn btn-block btn-lg btn-success', 'data' => [
                                            'confirm' => 'Tem certeza que deseja INICIAR a inspeção do item '. $model->item . '?',
                                            'method' => 'post',
                                        ],]);
		} else if(($model->status == "DOING" or $model->status == "doing")&& $model->iqc_received != NULL){
			echo Html::a('Finalizar Inspeção', ['stop', 'id' => $model->asn], ['class' => 'btn btn-block btn-lg btn-warning', 'data' => [
                                            'confirm' => 'Tem certeza que deseja FINALIZAR a inspeção do item '. $model->item . '?',
                                            'method' => 'post',
                                        ],]);
		} else if(($model->status == "DONE" or $model->status == "done") && $model->iqc_received != NULL){
			echo Html::a('Relatar Não Conformidade', ['alert', 'id' => $model->asn], ['class' => 'btn btn-block btn-lg btn-danger', 'data' => [
                                            'confirm' => 'Tem certeza que deseja RELATAR NÃO CONFORMIDADE do item '. $model->item . '?',
                                            'method' => 'post',
                                        ],]);
		}
	?>
	
	</div>
</div>
