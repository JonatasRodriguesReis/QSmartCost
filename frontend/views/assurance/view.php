<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Assurance */

$this->title = $model->plan;
$this->params['breadcrumbs'][] = ['label' => 'Assurances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS
  $('.example-popover').popover({
        container: 'body'
  })

  $('#popup_subitem').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var id = button.data('id');
      var recipient = button.data('nome');
      var judge = button.data('judge').replace(".","");
      var modal = $(this);
      //modal.find('.modal-title').text('New message to ' + recipient);
      modal.find('.modal-body #item-nome').text(recipient);
      if(judge == "OK"){
         modal.find('.modal-body #div-judge').html('<div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #32f032; border-radius:8px;height: 25px;width: 50px;"><b>OK</b></div>');
      }
      else{
        modal.find('.modal-body #div-judge').html('<div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #f00f0f; border-radius:8px;height: 25px; width: 50px;color:white;">NG</b></div>');
      }

      $.ajax({
                url: '?r=assurance/getreports&id='+id,
                success: function (data) {
                     modal.find('.modal-body #div-reports').html(data);
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
        });
 });

   
/*$(document).on('click','button',function(event){
        var recipient = $(this).data('nome');
        var popup = $('#popup_subitem');
        //popup.find('.modal-title').text('New message to ' + recipient);
        //popup.find('.modal-body input').val(recipient);
        popup.modal('show'); 
   });*/
   
JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);

?>
<br>
<div class="assurance-view">

    <!--<p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'plan',
        ],
    ]) ?> -->

    <div class="box box-danger container">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <?php 

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
            <table id="days-header" class="table   ">
                <?php echo $items?>
            </table>
        </div>  
        
    </div>

    <div class="modal fade" id="popup_subitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">Assurance Item</h4>
          </div>
          <div class="modal-body">
            
              <div class="form-group">
                <h4  class="modal-title"><b>Descrição</b></h4>
                <p style="margin-top: 5px" id="item-nome"></p>
              </div>
              <h4  class="modal-title"><b>Judge</b></h4>
              <div  id = "div-judge" style="display: inline-block;">
                <!--<label for="message-text" class="control-label">Message:</label> -->
                <!--<textarea class="form-control" id="message-text"></textarea>-->
              </div>

            <div style = "float:right;" id="div-reports">
               <!--<a href= <?php echo  Url::to('/ReportsFiles/' ) . "Boleto1.pdf"; ?> target="_blank">
                    <img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/pdf-icon.svg"; ?> > 
                </a>
               <a href="#"><img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/excel-icon.svg"; ?>> </a>
               <a href="#"><img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/powerpoint-icon.svg"; ?>> </a> -->
            </div>
          </div>
          <!--<div class="modal-footer">-->
            <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
            <!--<button type="button" class="btn btn-primary">Send message</button> -->
          <!--</div>-->
        </div>
      </div>
    </div>

     

</div>
