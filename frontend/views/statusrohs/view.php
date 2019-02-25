<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\statusrohs */
//$this->title = str_replace("'","' ",$model->month);
$this->title = $model->month . ' RoHS';
$this->params['breadcrumbs'][] = ['label' => 'StatusRoHS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  $(document).ready(function(){

         $('.example-popover').popover({
		    container: 'body'
		  })

		  /*$('.botao-item').each(function () {
			    $(this).on("click", function () {
			        alert($(this).data('id'));
			    });
		   });*/

		  /*$.ajax({
            url: '?r=Item/getByStatus',
            type: 'post',
            datatype: 'json',
            contentType: "application/json; charset=utf-8",
            data:JSON.stringify({id:$('p').data('id')}),
            success: function (data) {
            	//alert(data);
            },
            error: function(xhr, ajaxOptions, thrownError){
            	//alert(thrownError);
            }
          });*/

  });
  var th = $('.table-fixed').find('thead th');
	$('.table-fixed').on('scroll', function() {
	  th.css('transform', 'translateY('+ this.scrollTop +'px)');
	});

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);	
$this->registerCss('


.table-fixed { overflow-y: auto; height: 450px; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }

th     { background-color:#696969;color:#fff; }

');	
?>
</br>
<div class="statusrohs-view">

    <div class="box box-danger container">
        <div class="box-header with-border">
		<br>
			<h1><?= Html::encode($this->title) ?></h1>
		</div>

		<p id = "view-staturohs">
			<?php 
				/*if(Yii::$app->user->identity != null){
					if (Yii::$app->user->identity->admin == 1){
						echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ;
					}
				}*/
				
			?>
			

			<!--<?= Html::a('Delete', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
			]) ?>
			-->

		</p>

		<?php /*if($model->status == 'NG'){
				echo DetailView::widget([
				'model' => $model,
				'attributes' => [
				    [
						'attribute' => 'status',
						'contentOptions' => ['style' => 'color:' . 
							($model->status == 'PENDING'?'#e6b800': ($model->status == 'APPROVED'?'green':'red'))],
					],
					'reason'
				],
			  ]);
			}
			else{
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

			echo '<h5 style="display:inline;"><b>Plan: </b></h5> <p style="display:inline;">'. $numPlan .'</p>&ensp;&ensp;';

			echo '<h5 style="display:inline;"><b>Result: </b></h5><p style="display:inline;">'. $numResult .'</p>';
			echo '<h5><b>Progress</b></h5>';
			echo '<div class="progress" style = " width:60%;display:inline-block">

				  <div class="progress-bar " role="progressbar" style=" color:#000; background-color: #32f032;width:'. $numConcluido .'%;" aria-valuenow="'. $numConcluido .'" aria-valuemin="0" aria-valuemax="100"><b>'.$numConcluido.'%</b></div>
				</div>';
			echo '<div style="display:inline-block;float:right;"> 
					&ensp;<button type="button" class="btn example-popover " styledata-container="body" style = "height: 25px ;border-radius: 50px; background-color: #696969;" data-toggle="popover" data-placement="top" data-content="">
                    </button>&ensp;Data alterada</div>';
            echo '<div style="display:inline-block;float:right;"> 
					&ensp;<button type="button" class="btn  example-popover" styledata-container="body" style = "height: 25px ;border-radius: 50px;background-color:#CCCCCC;" data-toggle="popover" data-placement="top" data-content="">
                    </button>&ensp;Não Realizado&ensp;&ensp;</div>';
            echo '<div style="display:inline-block;float:right;"> 
					<button type="button" class="btn example-popover" styledata-container="body" style = "background-color: #32f032;height: 25px ;border-radius: 50px;" data-placement="top" data-content="">
                    </button>&ensp;Realizado&ensp;&ensp;</div>';
            
			 ?>	

	    <div class="table-fixed">    
	        <table id="days-header" class="table  table-striped table-hover">
	            <?php echo $items?>
	        </table>
	    </div>	
		
	</div>

</div>

<?php
$script = <<< JS

  $(document).ready(function() {
 
         
  		  
          $('#view-staturohs').click(function(){
          		//alert("h"+$(this).data('id'));
          });
          
          
          
  });

  


JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

