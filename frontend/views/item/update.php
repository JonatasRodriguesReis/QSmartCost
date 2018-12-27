<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Item */


$this->title = 'Update: ' . $model->nome;
//$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->nome, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<br>
<div class="item-update">

    <div class="box box-danger container">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <?php
        	$data_teste = $model->data_teste;
        	$ano = substr($data_teste, 0,4);
        	$mes = substr($data_teste, 5,2);
        	$dia_teste = substr($data_teste, 8,2);

            $start_date = "01-".$mes."-".$ano;
            $start_time = strtotime($start_date);

            $end_time = strtotime("+1 month", $start_time);

            for($i=$start_time; $i<$end_time; $i+=86400)
            {
               $list[] = date('Y-m-d-D', $i);
            }  

            $htm = '<thead style="background-color:#696969;color:#fff" data-date ='. $model->data_teste .'>
                    <tr >
                        <th></th>
            ';

            $dias_total = array();
            $datas_total = array();
            foreach ($list as $data) {
                //print_r(substr($data,-3));
                if(!(substr($data,-3) == 'Sun' || substr($data,-3) == 'Sat')){
                    $htm = $htm . '<th>'. substr($data, -6,-4) .'</th>';
                    //print_r($data." ");
                    array_push($dias_total,substr($data, -6,-4));
                    array_push($datas_total,substr($data,0,-4));
                }
                
            }

            $htm = $htm.'</tr></thead><tbody>';
            $trim = str_replace(" ","",$model->nome );
            $trim = str_replace(",","",$trim );
            $trim = str_replace("(","",$trim );
            $trim = str_replace(")","",$trim );
            $htm = $htm . '<tr><td style = "padding-top:18px;" data-id = "'. $model->id .'" data-nome = "'.$trim.'">' . $model->nome . '</td>';
			$i = 0;
            foreach ($dias_total as $dia) {
            	if($dia == $dia_teste){
            		$checked = " checked";
            	}else{
            		$checked = "";
            	}
                $htm = $htm .'
                   <td>
                      <div class="radio">
                         <label>
                            <input type="radio" name="radios_'. $trim .'" id="radio_' . $model->nome.'" value="'. $dia .'" data-date="'. $datas_total[$i] .'"' . $checked .'>
                         </label>
                      </div>
                   </td>
                ';
                $i = $i + 1;
            }
            $htm = $htm . '</tr>';
            $htm = $htm.'</tbody>';
            

        ?>

	    <?= $this->render('_form_update', [
	        'model' => $model,'htm' => $htm,'data_teste' => $model->data_teste
	    ]) ?>
	</div>

</div>
