<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InspectionscontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Energy Test Monitoring';
$this->params['breadcrumbs'][] = $this->title;

$connection = Yii::$app->getDb();

?>

<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
	text-align:center;
	
}
</style>
</head>
<body>
 
 <br>
<div class="box">
	<div class="box-header">
	<h1 class = "box-title"><?= Html::encode($this->title) ?></h1>
	</div>

<table class="table table-hover table-bordered">
	<thead style="background:#E8E8E8">
		<tr>
			<th style="vertical-align: middle" rowspan='2'>Status</th>
			<th style="vertical-align: middle" rowspan='2'>Model</th>
			<th style="vertical-align: middle" rowspan='2' colspan='2'>Especification</th> 
			<th style="vertical-align: middle" rowspan='2'>Standard INMETRO</th>
			<th style="vertical-align: middle" rowspan='2'>Standard LG</th>
			<th style="vertical-align: middle" rowspan='2'>Average</th>
			<th style="vertical-align: middle" rowspan='2'>LSL/USL</th>
			<th style="vertical-align: middle" rowspan='2'>STDEV</th>
			<th style="vertical-align: middle" rowspan='2'>Z Value</th>
			<th style="vertical-align: middle" colspan='2'>Judgment</th>
		</tr>
		<tr>
			<th>Zlt 3.0</th>
			<th>Margin 3%</th>   
		</tr>
	</thead>
	
	<tbody>
  
  <?php
   $command = $connection->createCommand("SELECT * FROM lg.calc_z_config");

      $result = $command->queryAll();
	  foreach ($result as $perk) {
		  $modelo = $perk['modelo'];
		  $modelo_split = explode('.',$modelo);
		  $valor_capacidade = $perk['valor_capacidade'];
		  $valor_eer = $perk['valor_eer'];
		  $valor_power = $perk['valor_power'];
		  
		  $capacidade_imetro = $valor_capacidade*0.92;
		  $eer_imetro = $valor_eer*0.92;
		  $power_imetro = $valor_power*1.08;
		  
		  $capacidade_lg = $valor_capacidade*0.95;
		  $eer_lg = $valor_eer*0.95;
		  $power_lg = $valor_power*1.05;
	
	 $command2 = $connection->createCommand("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power) FROM lg.calc_z_testes WHERE modelo LIKE '$modelo'");
	 $result2 = $command2->queryAll();
		foreach ($result2 as $perk2) {
			$average_capacidade = $perk2['AVG(valor_capacidade)'];
			$average_eer = $perk2['AVG(valor_eer)'];
			$average_power = $perk2['AVG(valor_power)'];
			break;
		}
		
	$command3 = $connection->createCommand("SELECT STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM lg.calc_z_testes WHERE modelo LIKE '$modelo'");
	$result3 = $command3->queryAll();
		foreach ($result3 as $perk3) {
			$desvpad_capacidade = $perk3['STDDEV_SAMP(valor_capacidade)'];
			$desvpad_eer = $perk3['STDDEV_SAMP(valor_eer)'];
			$desvpad_power = $perk3['STDDEV_SAMP(valor_power)'];
			break;
		}
		try {
			$valorz_capacidade = (($average_capacidade - $capacidade_imetro)/$desvpad_capacidade);
			$valorz_capacidade = number_format($valorz_capacidade, 1, '.', '');
		}catch(Exception $e) {
			$valorz_capacidade = 0;
		}
		
		try {
			$valorz_eer = (($average_eer - $eer_imetro)/$desvpad_eer);
			$valorz_eer = number_format($valorz_eer, 1, '.', '');
		}catch(Exception $e) {
			$valorz_eer = 0;
		}
		
		try {
			$valorz_power = -(($average_power - $power_imetro)/$desvpad_power);
			$valorz_power = number_format($valorz_power, 1, '.', '');
		}catch(Exception $e) {
			$valorz_power = 0;
		}
		
		$resultado_capacidade = "OK";
		$resultado_eer = "OK";
		$resultado_power = "OK";
		
		if ($valorz_capacidade < 3){
			$resultado_capacidade = "NG";
			$cor_capacidade = "danger";
		} else {
			$cor_capacidade = "success";
		}
		if ($valorz_eer < 3){
			$resultado_eer = "NG";
			$cor_eer = "danger";
		} else {
			$cor_eer = "success";
		}
		if ($valorz_power < 3){
			$resultado_power = "NG";
			$cor_power = "danger";
		}else {
			$cor_power = "success";
		}
		
		$command4 = $connection->createCommand("SELECT COUNT(id) FROM lg.calc_z_testes WHERE modelo LIKE '$modelo' AND data BETWEEN '2018-06-01' AND '2018-12-31'");
		$result4 = $command4->queryAll();
		foreach ($result4 as $perk4) {
			$contagem = $perk4['COUNT(id)'];
			break;
		}
		
		if ($contagem > 0) {
			$status = "DONE";
			$status_cor = "success";
		}else{
			$command5 = $connection->createCommand("SELECT COUNT(id) FROM lg.calc_z_testes WHERE modelo LIKE '$modelo' AND data BETWEEN '2017-12-01' AND '2018-06-31'");
			$result5 = $command5->queryAll();
			foreach ($result5 as $perk5) {
				$contagem2 = $perk5['COUNT(id)'];
			break;
			}
			if ($contagem2 > 0) {
				$status = "MISS";
				$status_cor = "warning";
			}else{
				$status = "EOL";
				$status_cor = "default";
			}
		}
		
		echo"
		<tr>
		<td style='vertical-align: middle' rowspan='4'>
			<a style='text-size: large' href='http://10.193.236.145:85/QSmart/advanced/frontend/web/index.php?CalcZTestesSearch%5Bdata%5D=&CalcZTestesSearch%5Bmodelo%5D=".$modelo."&CalcZTestesSearch%5Bvalor_capacidade%5D=&CalcZTestesSearch%5Bvalor_eer%5D=&CalcZTestesSearch%5Bvalor_power%5D=&r=calc-z-testes%2Fhistorico&sort=-data'>
			<h4><span class='label label-".$status_cor."'>".$status."</span></h4>
			</a>
		</td>
		</tr>
		<tr>
			<td style='vertical-align: middle' rowspan='3'>
				<a style='text-size: large' href='http://10.193.236.145:85/QSmart/advanced/frontend/web/index.php?r=calc-z-testes/zcalcgraph&modelo=".$modelo."&valor_capacidade=".$valor_capacidade."&valor_eer=".$valor_eer."&valor_power=".$valor_power."&valorz_capacidade=".$valorz_capacidade."&valorz_eer=".$valorz_eer."&valorz_power=".$valorz_power."&capacidade_imetro=".$capacidade_imetro."&eer_imetro=".$eer_imetro."&power_imetro=".$power_imetro."'><font size='4'>".$modelo_split[0]."</font></a>
				<br>
			</td>
			<td style='text-align:left'>Capacidade</td>
			<td>".$valor_capacidade."</td>
			<td>".$capacidade_imetro."</td>
			<td>".$capacidade_lg."</td>
			<td>".number_format($average_capacidade, 1, '.', '')."</td>
			<td>".$capacidade_imetro."</td>
			<td>".number_format($desvpad_capacidade, 1, '.', '')."</td>
			<td>".$valorz_capacidade."</td>
			<td><h4><span class='label label-".$cor_capacidade."'>".$resultado_capacidade."</span></h4></td>
			<td><h4><span class='label label-".$cor_capacidade."'>".$resultado_capacidade."</span></h4></td>
		</tr>
		
		<tr>
			<td style='text-align:left'>EER</td>
			<td>".$valor_eer."</td>
			<td>".$eer_imetro."</td>
			<td>".$eer_lg."</td>
			<td>".number_format($average_eer, 1, '.', '')."</td>
			<td>".$eer_imetro."</td>
			<td>".number_format($desvpad_eer, 1, '.', '')."</td>
			<td>".$valorz_eer."</td>
			<td><h4><span class='label label-".$cor_eer."'>".$resultado_eer."</span></h4></td>
			<td><h4><span class='label label-".$cor_eer."'>".$resultado_eer."</span></h4></td>
		</tr>
		
		<tr>
			<td style='text-align:left'>Power</td>
			<td>".$valor_power."</td>
			<td>".$power_imetro."</td>
			<td>".$power_lg."</td>
			<td>".number_format($average_power, 1, '.', '')."</td>
			<td>".$power_imetro."</td>
			<td>".number_format($desvpad_power, 1, '.', '')."</td>
			<td>".$valorz_power."</td>
			<td><h4><span class='label label-".$cor_power."'>".$resultado_power."</span></h4></td>
			<td><h4><span class='label label-".$cor_power."'>".$resultado_power."</span></h4></td>
		</tr>
		  ";
      };   
  ?>
  <tbody>
</table>

</div>
