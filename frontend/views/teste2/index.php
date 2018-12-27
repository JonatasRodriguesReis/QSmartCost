<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Teste2Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

/*<p>
        <?= Html::a('Create Teste2', ['create'], ['class' => 'btn btn-success']) ?>
    </p>*/

$this->title = 'Teste2s';
$this->params['breadcrumbs'][] = $this->title;
?>
</br>
<div class="teste2-index">

	<div class="box box-danger">
        <div class="box-header with-border">
		<br>
			<h1><?= Html::encode($this->title) ?></h1>
		</div>

		<p>
        <?= Html::a('Create Teste2', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'filterModel' => $searchModel,
			'columns' => [
				['class' => 'yii\grid\SerialColumn'],

				'nome',

				['class' => 'yii\grid\ActionColumn',                        
							'template' => '{view} {start} {stop} {edit}',                        
							'buttons' => [
								'view' => function($url,$model) {
										return Html::a(
											'<span class="fa fa-eye"></span>',
											['view', 'id' => $model->id], [
												'class' => 'btn btn-default',
												'title' => 'Visualizar Detalhes',
												'data-pjax' => '0',
											]
										);
								},
								
							  
							],
				],
			],
		]); ?>
	</div>
</div>
