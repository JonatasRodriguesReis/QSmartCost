<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\InspectionscontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Energy Test Graph';
$this->params['breadcrumbs'][] = ['label' => 'Energy Test Monitoring', 'url' => ['zcalc']];
$this->params['breadcrumbs'][] = $this->title;

$modelo = $_GET["modelo"];
$modelo_split = explode('.',$modelo);
$valor_capac = $_GET["valor_capacidade"];
$valor_e = $_GET["valor_eer"];
$valor_pow = $_GET["valor_power"];
$capacidade_imetro = $_GET["capacidade_imetro"];
$eer_imetro = $_GET["eer_imetro"];
$power_imetro = $_GET["power_imetro"];


?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<!--<script src="http://10.193.236.94:85/QSmart/advanced/frontend/web/js/Chart.min.js"></script> -->

<script src= <?php echo Yii::$app->request->baseUrl . "/js/Chart.min.js"; ?> ></script>
<h2><?=$modelo_split[0]?></h2>
<!--
<p align = "left">
<?php
echo Html::a('Histórico de Testes', ['historico', 'id' => $modelo], ['class' => 'btn btn-primary btn-sm']);
?>
</p>
-->

<div class="box">
	<div class="box-header">
	<h2 class = "box-title">Capacity / EER</h2>
	</div>
<canvas id="myChart" width="90vw" height="15vh"></canvas>
</div>

<div class="box">
	<div class="box-header">
	<h2 class = "box-title">Power</h2>
	</div>
<canvas id="myChart2" width="90vw" height="15vh"></canvas>
</div>

<div class="box">
	<div class="box-header">
	<h2 class = "box-title">Z-Value</h2>
	</div>
<canvas id="myChart3" width="90vw" height="15vh"></canvas>
</div>

<?php 
$conn = new mysqli("localhost", "root", "", "lg");

	$result = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2015-06-31 00:00:00'");
	$outp = array();
    $outp = $result->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp as $value) {
		$valor_capacidade = $value['AVG(valor_capacidade)'];
		$valor_eer = $value['AVG(valor_eer)'];
		$valor_power = $value['AVG(valor_power)'];
		$stddeev_capacidade = $value['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value['STDDEV_SAMP(valor_power)'];
		
		if($valor_capac == null){
			$valor_capacidade_grafico = 0;
		} else {
			$valor_capacidade_grafico = (($valor_capacidade*100)/$valor_capac);
		}
		
		$valor_eer_grafico = (($valor_eer*100)/$valor_e);
		$valor_power_grafico = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico = 0;
		} else {
			$stddeev_capacidade_grafico = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico = 0;
		} else {
			$stddeev_eer_grafico = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico = 0;
		} else {
			$stddeev_power_grafico = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico = number_format($valor_capacidade_grafico, 1, '.', '');
		$valor_eer_grafico = number_format($valor_eer_grafico, 1, '.', '');
		$valor_power_grafico = number_format($valor_power_grafico, 1, '.', '');
		$stddeev_capacidade_grafico = number_format($stddeev_capacidade_grafico, 1, '.', '');
		$stddeev_eer_grafico = number_format($stddeev_eer_grafico, 1, '.', '');
		$stddeev_power_grafico = number_format($stddeev_power_grafico, 1, '.', '');
		
    }	   
	
	$result2 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2015-12-31 00:00:00'");
	$outp2 = array();
    $outp2 = $result2->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp2 as $value2) {
		$valor_capacidade = $value2['AVG(valor_capacidade)'];
		$valor_eer = $value2['AVG(valor_eer)'];
		$valor_power = $value2['AVG(valor_power)'];
		$stddeev_capacidade = $value2['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value2['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value2['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico2 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico2 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico2 = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico2 = 0;
		} else {
			$stddeev_capacidade_grafico2 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico2 = 0;
		} else {
			$stddeev_eer_grafico2 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico2 = 0;
		} else {
			$stddeev_power_grafico2 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico2 = number_format($valor_capacidade_grafico2, 1, '.', '');
		$valor_eer_grafico2 = number_format($valor_eer_grafico2, 1, '.', '');
		$valor_power_grafico2 = number_format($valor_power_grafico2, 1, '.', '');
		$stddeev_capacidade_grafico2 = number_format($stddeev_capacidade_grafico2, 1, '.', '');
		$stddeev_eer_grafico2 = number_format($stddeev_eer_grafico2, 1, '.', '');
		$stddeev_power_grafico2 = number_format($stddeev_power_grafico2, 1, '.', '');
    }	   
	
	$result3 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2016-06-31 00:00:00'");
	$outp3 = array();
    $outp3 = $result3->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp3 as $value3) {
		$valor_capacidade = $value3['AVG(valor_capacidade)'];
		$valor_eer = $value3['AVG(valor_eer)'];
		$valor_power = $value3['AVG(valor_power)'];
		$stddeev_capacidade = $value3['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value3['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value3['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico3 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico3 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico3 = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico3 = 0;
		} else {
			$stddeev_capacidade_grafico3 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico3 = 0;
		} else {
			$stddeev_eer_grafico3 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico3 = 0;
		} else {
			$stddeev_power_grafico3 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico3 = number_format($valor_capacidade_grafico3, 1, '.', '');
		$valor_eer_grafico3 = number_format($valor_eer_grafico3, 1, '.', '');
		$valor_power_grafico3 = number_format($valor_power_grafico3, 1, '.', '');
		$stddeev_capacidade_grafico3 = number_format($stddeev_capacidade_grafico3, 1, '.', '');
		$stddeev_eer_grafico3 = number_format($stddeev_eer_grafico3, 1, '.', '');
		$stddeev_power_grafico3 = number_format($stddeev_power_grafico3, 1, '.', '');
    }	   
	
	$result4 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2016-12-31 00:00:00'");
	$outp4 = array();
    $outp4 = $result4->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp4 as $value4) {
		$valor_capacidade = $value4['AVG(valor_capacidade)'];
		$valor_eer = $value4['AVG(valor_eer)'];
		$valor_power = $value4['AVG(valor_power)'];
		$stddeev_capacidade = $value4['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value4['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value4['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico4 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico4 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico4 = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico4 = 0;
		} else {
			$stddeev_capacidade_grafico4 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico4 = 0;
		} else {
			$stddeev_eer_grafico4 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico4 = 0;
		} else {
			$stddeev_power_grafico4 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico4 = number_format($valor_capacidade_grafico4, 1, '.', '');
		$valor_eer_grafico4 = number_format($valor_eer_grafico4, 1, '.', '');
		$valor_power_grafico4 = number_format($valor_power_grafico4, 1, '.', '');
		$stddeev_capacidade_grafico4 = number_format($stddeev_capacidade_grafico4, 1, '.', '');
		$stddeev_eer_grafico4 = number_format($stddeev_eer_grafico4, 1, '.', '');
		$stddeev_power_grafico4 = number_format($stddeev_power_grafico4, 1, '.', '');
    }	   
	
	$result5 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2017-06-31 00:00:00'");
	$outp5 = array();
    $outp5 = $result5->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp5 as $value5) {
		$valor_capacidade = $value5['AVG(valor_capacidade)'];
		$valor_eer = $value5['AVG(valor_eer)'];
		$valor_power = $value5['AVG(valor_power)'];
		$stddeev_capacidade = $value5['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value5['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value5['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico5 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico5 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico5 = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico5 = 0;
		} else {
			$stddeev_capacidade_grafico5 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico5 = 0;
		} else {
			$stddeev_eer_grafico5 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico5 = 0;
		} else {
			$stddeev_power_grafico5 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico5 = number_format($valor_capacidade_grafico5, 1, '.', '');
		$valor_eer_grafico5 = number_format($valor_eer_grafico5, 1, '.', '');
		$valor_power_grafico5 = number_format($valor_power_grafico5, 1, '.', '');
		$stddeev_capacidade_grafico5 = number_format($stddeev_capacidade_grafico5, 1, '.', '');
		$stddeev_eer_grafico5 = number_format($stddeev_eer_grafico5, 1, '.', '');
		$stddeev_power_grafico5 = number_format($stddeev_power_grafico5, 1, '.', '');
    }	   
	
	$result6 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2017-12-31 00:00:00'");
	$outp6 = array();
    $outp6 = $result6->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp6 as $value6) {
		$valor_capacidade = $value6['AVG(valor_capacidade)'];
		$valor_eer = $value6['AVG(valor_eer)'];
		$valor_power = $value6['AVG(valor_power)'];
		$stddeev_capacidade = $value6['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value6['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value6['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico6 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico6 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico6 = (($valor_power*100)/$valor_pow);
		
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico6 = 0;
		} else {
			$stddeev_capacidade_grafico6 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico6 = 0;
		} else {
			$stddeev_eer_grafico6 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico6 = 0;
		} else {
			$stddeev_power_grafico6 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
		
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico6 = number_format($valor_capacidade_grafico6, 1, '.', '');
		$valor_eer_grafico6 = number_format($valor_eer_grafico6, 1, '.', '');
		$valor_power_grafico6 = number_format($valor_power_grafico6, 1, '.', '');
		$stddeev_capacidade_grafico6 = number_format($stddeev_capacidade_grafico6, 1, '.', '');
		$stddeev_eer_grafico6 = number_format($stddeev_eer_grafico6, 1, '.', '');
		$stddeev_power_grafico6 = number_format($stddeev_power_grafico6, 1, '.', '');
    }	   
	
	$result7 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2018-06-31 00:00:00'");
	$outp7 = array();
    $outp7 = $result7->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp7 as $value7) {
		$valor_capacidade = $value7['AVG(valor_capacidade)'];
		$valor_eer = $value7['AVG(valor_eer)'];
		$valor_power = $value7['AVG(valor_power)'];
		$stddeev_capacidade = $value7['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value7['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value7['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico7 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico7 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico7 = (($valor_power*100)/$valor_pow);
	
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico7 = 0;
		} else {
			$stddeev_capacidade_grafico7 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico7 = 0;
		} else {
			$stddeev_eer_grafico7 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico7 = 0;
		} else {
			$stddeev_power_grafico7 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
	
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico7 = number_format($valor_capacidade_grafico7, 1, '.', '');
		$valor_eer_grafico7 = number_format($valor_eer_grafico7, 1, '.', '');
		$valor_power_grafico7 = number_format($valor_power_grafico7, 1, '.', '');
		$stddeev_capacidade_grafico7 = number_format($stddeev_capacidade_grafico7, 1, '.', '');
		$stddeev_eer_grafico7 = number_format($stddeev_eer_grafico7, 1, '.', '');
		$stddeev_power_grafico7 = number_format($stddeev_power_grafico7, 1, '.', '');
    }	   
	
	$result8 = $conn->query("SELECT AVG(valor_capacidade), AVG(valor_eer), AVG(valor_power), STDDEV_SAMP(valor_capacidade), STDDEV_SAMP(valor_eer), STDDEV_SAMP(valor_power) FROM `calc_z_testes` WHERE modelo LIKE '$modelo' and data BETWEEN '2014-01-01 00:00:00' AND '2018-12-31 00:00:00'");
	$outp8 = array();
    $outp8 = $result8->fetch_all(MYSQLI_ASSOC);
	
	foreach ($outp8 as $value8) {
		$valor_capacidade = $value8['AVG(valor_capacidade)'];
		$valor_eer = $value8['AVG(valor_eer)'];
		$valor_power = $value8['AVG(valor_power)'];
		$stddeev_capacidade = $value8['STDDEV_SAMP(valor_capacidade)'];
		$stddeev_eer = $value8['STDDEV_SAMP(valor_eer)'];
		$stddeev_power = $value8['STDDEV_SAMP(valor_power)'];
		
		$valor_capacidade_grafico8 = (($valor_capacidade*100)/$valor_capac);
		$valor_eer_grafico8 = (($valor_eer*100)/$valor_e);
		$valor_power_grafico8 = (($valor_power*100)/$valor_pow);
	
		if($stddeev_capacidade == null){
			$stddeev_capacidade_grafico8 = 0;
		} else {
			$stddeev_capacidade_grafico8 = (($valor_capacidade - $capacidade_imetro)/$stddeev_capacidade);
		}
		
		if($stddeev_eer == null){
			$stddeev_eer_grafico8 = 0;
		} else {
			$stddeev_eer_grafico8 = (($valor_eer - $eer_imetro)/$stddeev_eer);
		}
		
		if($stddeev_power == null){
			$stddeev_power_grafico8 = 0;
		} else {
			$stddeev_power_grafico8 = -(($valor_power - $power_imetro)/$stddeev_power);
		}
	
		//Adicionando 2 casas decimais
		$valor_capacidade_grafico8 = number_format($valor_capacidade_grafico8, 1, '.', '');
		$valor_eer_grafico8 = number_format($valor_eer_grafico8, 1, '.', '');
		$valor_power_grafico8 = number_format($valor_power_grafico8, 1, '.', '');
		$stddeev_capacidade_grafico8 = number_format($stddeev_capacidade_grafico8, 1, '.', '');
		$stddeev_eer_grafico8 = number_format($stddeev_eer_grafico8, 1, '.', '');
		$stddeev_power_grafico8 = number_format($stddeev_power_grafico8, 1, '.', '');
		
		$teste = number_format(3, 1, '.', '');
    }
?>

</body>

<script>
			
        var dados = {
            labels: ['2015 1H', '2015 2H', '2016 1H', '2016 2H', '2017 1H', '2017 2H', '2018 1H', '2018 2H'],
            datasets: [
				{
                    label: "Target",
                    fill:false,
                    backgroundColor: '#888888',
                    borderColor: '#888888',
					borderDash: [5, 5],
                    data:[95, 95, 95, 95, 95, 95, 95, 95],
                    
					pointBorderColor:'#888888',
					pointBackgroundColor: '#888888',
					pointRadius: 4,
                    pointHoverRadius: 8,					
                },
				
                {
                    label: "Capacity",
                    fill:false,
                    backgroundColor: '#007700',
                    borderColor: '#007700',
					data:[<?php  echo json_encode($valor_capacidade_grafico)?>, <?php  echo json_encode($valor_capacidade_grafico2)?>, <?php  echo json_encode($valor_capacidade_grafico3)?>, <?php  echo json_encode($valor_capacidade_grafico4)?>, <?php  echo json_encode($valor_capacidade_grafico5)?>, <?php  echo json_encode($valor_capacidade_grafico6)?>, <?php  echo json_encode($valor_capacidade_grafico7)?>, <?php  echo json_encode($valor_capacidade_grafico8)?>,],
                    
					pointBorderColor:'#007700',
					pointBackgroundColor: '#007700',
					pointRadius: 4,
                    pointHoverRadius: 8,
                },
                {
                    label: "EER",
                    fill:false,
                    backgroundColor: '#880000',
                    borderColor: '#880000',
                    data:[<?php  echo json_encode($valor_eer_grafico)?>, <?php  echo json_encode($valor_eer_grafico2)?>, <?php  echo json_encode($valor_eer_grafico3)?>, <?php  echo json_encode($valor_eer_grafico4)?>, <?php  echo json_encode($valor_eer_grafico5)?>, <?php  echo json_encode($valor_eer_grafico6)?>, <?php  echo json_encode($valor_eer_grafico7)?>, <?php  echo json_encode($valor_eer_grafico8)?>, ],
                    
					pointBorderColor:'#880000',
					pointBackgroundColor: '#880000',
					pointRadius: 4,
                    pointHoverRadius: 8,					
                },
                
            ]}
			
			var dados2 = {
            labels: ['2015 1H', '2015 2H', '2016 1H', '2016 2H', '2017 1H', '2017 2H', '2018 1H', '2018 2H'],
            datasets: [
				{
                    label: "Target",
                    fill:false,
                    backgroundColor: '#888888',
                    borderColor: '#888888',
					borderDash: [5, 5],
                    data:[105, 105, 105, 105, 105, 105, 105, 105],
                    
					pointBorderColor:'#888888',
					pointBackgroundColor: '#888888',
					pointRadius: 4,
                    pointHoverRadius: 8,					
                },
				
                {
                    label: "Power",
                    fill:false,
                    backgroundColor: '#000000',
                    borderColor: '#000000',
					data:[<?php  echo json_encode($valor_power_grafico)?>, <?php  echo json_encode($valor_power_grafico2)?>, <?php  echo json_encode($valor_power_grafico3)?>, <?php  echo json_encode($valor_power_grafico4)?>, <?php  echo json_encode($valor_power_grafico5)?>, <?php  echo json_encode($valor_power_grafico6)?>, <?php  echo json_encode($valor_power_grafico7)?>, <?php  echo json_encode($valor_power_grafico8)?>, ],
                    
					pointBorderColor:'#000000',
					pointBackgroundColor: '#000000',
					pointRadius: 4,
                    pointHoverRadius: 8,
                },
                
            ]}
			
			var dados3 = {
            labels: ['2015 1H', '2015 2H', '2016 1H', '2016 2H', '2017 1H', '2017 2H', '2018 1H', '2018 2H'],
            datasets: [
				{
                    label: "Target",
                    fill:false,
                    backgroundColor: '#888888',
                    borderColor: '#888888',
					borderDash: [5, 5],
                    data:[<?php  echo json_encode($teste)?>, 3, 3, 3, 3, 3, 3, 3],
                    
					pointBorderColor:'#888888',
					pointBackgroundColor: '#888888',
					pointRadius: 4,
                    pointHoverRadius: 8,					
                },
				
                {
                    label: "Capacity",
                    fill:false,
                    backgroundColor: '#007700',
                    borderColor: '#007700',
					data:[<?php  echo json_encode($stddeev_capacidade_grafico)?>, <?php  echo json_encode($stddeev_capacidade_grafico2)?>, <?php  echo json_encode($stddeev_capacidade_grafico3)?>, <?php  echo json_encode($stddeev_capacidade_grafico4)?>, <?php  echo json_encode($stddeev_capacidade_grafico5)?>, <?php  echo json_encode($stddeev_capacidade_grafico6)?>, <?php  echo json_encode($stddeev_capacidade_grafico7)?>, <?php  echo json_encode($stddeev_capacidade_grafico8)?>, ],
                    
					pointBorderColor:'#007700',
					pointBackgroundColor: '#007700',
					pointRadius: 4,
                    pointHoverRadius: 8,
                },
				
				{
                    label: "EER",
                    fill:false,
                    backgroundColor: '#880000',
                    borderColor: '#880000',
                    data:[<?php  echo json_encode($stddeev_eer_grafico)?>, <?php  echo json_encode($stddeev_eer_grafico2)?>, <?php  echo json_encode($stddeev_eer_grafico3)?>, <?php  echo json_encode($stddeev_eer_grafico4)?>, <?php  echo json_encode($stddeev_eer_grafico5)?>, <?php  echo json_encode($stddeev_eer_grafico6)?>, <?php  echo json_encode($stddeev_eer_grafico7)?>, <?php  echo json_encode($stddeev_eer_grafico8)?>, ],
                    
					pointBorderColor:'#880000',
					pointBackgroundColor: '#880000',
					pointRadius: 4,
                    pointHoverRadius: 8,					
                },
				
				{
                    label: "Power",
                    fill:false,
                    backgroundColor: '#000000',
                    borderColor: '#000000',
					data:[<?php  echo json_encode($stddeev_power_grafico)?>, <?php  echo json_encode($stddeev_power_grafico2)?>, <?php  echo json_encode($stddeev_power_grafico3)?>, <?php  echo json_encode($stddeev_power_grafico4)?>, <?php  echo json_encode($stddeev_power_grafico5)?>, <?php  echo json_encode($stddeev_power_grafico6)?>, <?php  echo json_encode($stddeev_power_grafico7)?>, <?php  echo json_encode($stddeev_power_grafico8)?>, ],
                    
					pointBorderColor:'#000000',
					pointBackgroundColor: '#000000',
					pointRadius: 4,
                    pointHoverRadius: 8,
                },
                
            ]}

        var ctx = document.getElementById("myChart").getContext("2d");
        var ctx2 = document.getElementById("myChart2").getContext("2d");
        var ctx3 = document.getElementById("myChart3").getContext("2d");
		
        var options =
            {
			responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false,
							min: 90
                        }
                    }]
                }
            }
			
			var options2 =
            {
			responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:false,
							max: 110
                        }
                    }]
                }
            }
			
			var options3 =
            {
			responsive: true,
                tooltips: {
                    mode: 'index',
                    intersect: false,
                },
                hover: {
                    mode: 'nearest',
                    intersect: true
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true,
                        }
                    }]
                }
            }

        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: dados,
            options: options
        });
		
		 var myLineChart2 = new Chart(ctx2, {
            type: 'line',
            data: dados2,
            options: options2
        });
		
		var myLineChart3 = new Chart(ctx3, {
            type: 'line',
            data: dados3,
            options: options3
        });

</script>
