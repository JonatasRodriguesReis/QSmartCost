<script src="localhost:85/QSmart/advanced/frontend/web/js/Chart.min.js"></script>
<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InspectionscontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inspections/Non Inspections Control - RAC';
$this->params['breadcrumbs'][] = $this->title;

$connection = Yii::$app->getDb();

	//FORNECEDORES LOCAIS
      $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE tipo LIKE 'LOCAL'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $total = $perk['COUNT(item)'];
        break;
      }
	  
	  $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE method LIKE 'Inspection ' AND tipo LIKE 'LOCAL'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $ok = $perk['COUNT(item)'];
        break;
      }
	  
	  $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE method LIKE 'Non-Inspection' AND tipo LIKE 'LOCAL'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $ng = $perk['COUNT(item)'];
        break;
      }
	  
	  $resultOK = number_format(($ok*100)/$total, 1, '.' , ',');
	  $resultNG = number_format(($ng*100)/$total, 1, '.' , ',');
	  
	  $checkInsp = $total - $ok - $ng;
	  $resultCheckInsp = number_format(100 - $resultOK - $resultNG, 1, '.' , ',');
	  
	  
	  //FORNECEDORES IMPORTADOS
	  $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE tipo LIKE 'IMPORTADO'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $totalImportado = $perk['COUNT(item)'];
        break;
      }
	  
	  $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE method LIKE 'Inspection ' AND tipo LIKE 'IMPORTADO'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $okImportado = $perk['COUNT(item)'];
        break;
      }
	  
	  $command = $connection->createCommand("SELECT COUNT(item) FROM lg.inspectionscontrol WHERE method LIKE 'Non-Inspection' AND tipo LIKE 'IMPORTADO'");

      $result = $command->queryAll();
      foreach ($result as $perk) {
        $ngImportado = $perk['COUNT(item)'];
        break;
      }
	  
	  $resultOKImportado = number_format(($okImportado*100)/$totalImportado, 1, '.' , ',');
	  $resultNGImportado = number_format(($ngImportado*100)/$totalImportado, 1, '.' , ',');
	  
	  $checkInspImportado = $totalImportado - $okImportado - $ngImportado;
	  $resultCheckInspImportado = number_format(100 - $resultOKImportado - $resultNGImportado, 1, '.' , ',');
	   
?>

<!--adp73193304-->

<div class="inspectionscontrol-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="col-md-3">
		<a href="http://10.193.236.87:85/QSmart/advanced/frontend/web?r=inspectionscontrol">
		<div class="callout callout-info">
			<h4>TOTAL</h4>
			<h4>Local - <?php echo $total?> Itens</h4>
			<h4>Imported - <?php echo $totalImportado?> Itens</h4>
		</div>
		</a>
	</div>
	
	<div class="col-md-3">
		<a href="http://10.193.236.87:85/QSmart/advanced/frontend/web?InspectionscontrolSearch[method]=Inspection+&r=inspectionscontrol">
		<div class="callout callout-success">
			<h4>INSPECTION</h4>
			<h4>Local - <?php echo $ok?> Itens - <?php echo $resultOK?>%</h4>
			<h4>Imported - <?php echo $okImportado?> Itens - <?php echo $resultOKImportado?>%</h4>
		</div>
		</a>
	</div>
	
	<div class="col-md-3">
		<a href="http://10.193.236.87:85/QSmart/advanced/frontend/web?InspectionscontrolSearch[method]=Non-Inspection&r=inspectionscontrol">
		<div class="callout callout-danger">
			<h4>NON INSPECTION</h4>
			<h4>Local - <?php echo $ng?> Itens - <?php echo $resultNG?>% </h4>
			<h4>Imported - <?php echo $ngImportado?> Itens - <?php echo $resultNGImportado?>% </h4>
		</div>
		</a>
	</div>	
	
	<div class="col-md-3">
		<a href="http://10.193.236.87:85/QSmart/advanced/frontend/web?InspectionscontrolSearch[method]=Check-Inspection&r=inspectionscontrol">
		<div class="callout callout-warning">
			<h4>CHECK-INSPECTION</h4>
			<h4>Local - <?php echo $checkInsp?> Itens - <?php echo $resultCheckInsp?>% </h4>
			<h4>Imported - <?php echo $checkInspImportado?> Itens - <?php echo $resultCheckInspImportado?>% </h4>
		</div>
		</a>
	</div>	
	
	<!--
	<div class="col-md-3" align="center" style="background-color:gray; color:white; font-size:20px"><b>TOTAL</b></div>
	<div class="col-md-3" align="center" style="background-color:green; color:white; font-size:20px"><b>INSPECTION</b></div>
	<div class="col-md-3" align="center"style="background-color:red; color:white; font-size:20px"><b>NON INSPECTION</b></div>
	<div class="col-md-3" align="center"style="background-color:yellow; color:gray; font-size:20px"><b>CHECK-INSPECTION</b></div>

	<div class="col-md-1" align="center"style="background-color:gray; color:white; font-size:20px">Local</div>
	<div class="col-md-2" align="center"style="background-color:gray; color:white; font-size:20px"><?php echo $total?> Itens </div>
	<div class="col-md-2" align="center"style="background-color:green; color:white; font-size:20px"> <?php echo $ok?> Itens </div>
	<div class="col-md-1" align="center"style="background-color:green; color:white; font-size:20px"> <?php echo $resultOK?>% </div>
	<div class="col-md-2" align="center"style="background-color:red; color:white; font-size:20px"> <?php echo $ng?> Itens </div>
	<div class="col-md-1" align="center"style="background-color:red; color:white; font-size:20px"> <?php echo $resultNG?>% </div>
	<div class="col-md-2" align="center"style="background-color:yellow; color:gray; font-size:20px"><b> <?php echo $checkInsp?> Itens </b></div>
	<div class="col-md-1" align="center"style="background-color:yellow; color:gray; font-size:20px"><b> <?php echo $resultCheckInsp?>% </b></div>
	
	<div class="col-md-1" align="center"style="background-color:gray; color:white; font-size:20px"> Imported</div>
	<div class="col-md-2" align="center"style="background-color:gray; color:white; font-size:20px"> <?php echo $totalImportado?> Itens</div>
	<div class="col-md-2" align="center"style="background-color:green; color:white; font-size:20px"> <?php echo $okImportado?> Itens </div>
	<div class="col-md-1" align="center"style="background-color:green; color:white; font-size:20px"> <?php echo $resultOKImportado?>% </div>
	<div class="col-md-2" align="center"style="background-color:red; color:white; font-size:20px"> <?php echo $ngImportado?> Itens </div>
	<div class="col-md-1" align="center"style="background-color:red; color:white; font-size:20px"> <?php echo $resultNGImportado?>% </div>
	<div class="col-md-2" align="center"style="background-color:yellow; color:gray; font-size:20px"><b> <?php echo $checkInspImportado?> Itens </b></div>
	<div class="col-md-1" align="center"style="background-color:yellow; color:gray; font-size:20px"><b> <?php echo $resultCheckInspImportado?>% </b></div>
	-->	
	
	
	<!--<div class="col-md-2" align="center"style="background-color:yellow; color:gray; font-size:20px">1</div>
	<div class="col-md-1" align="center"style="background-color:yellow; color:gray; font-size:20px">1</div>
	-->	
	<!--
    <p>
        <?= Html::a('Create Inspectionscontrol', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	-->
	
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item',
            'item_name',
            'method',
            'count',
			/*
			[
				'label' => 'Count Lot OK',
				'value' => function ($model) {
					return $model->Balance($model);
				}
			],*/
            'persist',
            // 'reason',
             'fornecedor',
			
			

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
	
	Last Update: 2018-02-07 12:00:00
	
</div>

<script>

$(document).ready(function() {
	
    document.getElementsByTagName("body").className = "sidebar-collapse";
}
);


        var dados = {
            labels: ['2016', '2017'],
            datasets: [
                {
                    label: "Repair",
                    fill:false,
                    backgroundColor: '#363636',
                    borderColor: '#363636',
					data: [1.73, 2.90],
                },
                {
                    label: "Return",
                    fill:false,
                    backgroundColor: '#696969',
                    borderColor: '#696969',
                    data: [3.16, 3.33],			
                },
            ]}

        var ctx = document.getElementById("myChart").getContext("2d");
        var options =
            {
			responsive: true,
				title: {
					display: true,
					text: 'F-Cost_RAC'
				},
                tooltips: {
                    mode: 'index',
                    intersect: true,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    yAxes: [{
					stacked:true,
                        ticks: {
                            beginAtZero:true
                        }
                    }],
					xAxes: [{
					stacked:true,
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }

        var myLineChart = new Chart(ctx, {
            type: 'horizontalBar',
            data: dados,
            options: options
        });

</script>
