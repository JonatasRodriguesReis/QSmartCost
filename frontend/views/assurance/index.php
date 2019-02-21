<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AssuranceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Assurances';
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){
        
        $.ajax({
            url: '?r=assurance/getanos',
            type: 'get',
            success: function (data) {
                $('#container').html(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        }); 

        $.ajax({
            url: '?r=assurance/gerar',
            type: 'get',
            success: function (data) {
                //alert(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
        });


  });


  $(document).on('change','select',function(){
        var path = '?r=assurance/getmonths&ano=';
        var path = path.concat($('select').val());
        $.ajax({
            url: path,
            type: 'get',
            success: function (data) {
                $('#cards').html(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
          }); 
       
   });



JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>
</br>
<div class="assurance-index">
        <div class="box box-danger container">
            <div class="box-header with-border">
            <br>
                <h1><?= Html::encode($this->title) ?></h1>
            </div>

            <!--<p>
                <?= Html::a('Gerar Plano', ['create'], ['class' => 'btn btn-success']) ?>
            </p> -->
           
            <div id="container">
            </div>
            
        </div>
</div>
