<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\assurance;

/* @var $this yii\web\View */
/* @var $model common\models\ItemAssurance */
$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'Assurances', 'url' => ['assurance/index']];
$this->params['breadcrumbs'][] = ['label' => assurance::findOne($idassurance)['plan'], 'url' => ['assurance/view' , 'id'=> $idassurance ]];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  var id;

  $(document).on('click','.btn-atualizar',function(){
       var id = $(this).data('subitem'); 
       //alert('?r=itemassurance/atualizarsubitemarquivo&id='+id);     
       var formData = new FormData($('#form-file-'+id)[0]);
        $.ajax({
                    url: '?r=itemassurance/atualizarsubitemarquivo&id='+id,
                    type: 'post',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,                        
                    success: function (result) {
                        //alert('Result: ' + result);
                    },
                     error: function(xhr, ajaxOptions, thrownError){
                        alert(thrownError);
                    }
         });

       var situacao = $('#subitem-'+$(this).data('subitem')+' #select-situacao').val();
       var judge = $('#subitem-'+$(this).data('subitem')+' #select-judge').val();
       var data_teste = $('#subitem-'+$(this).data('subitem')+' #data-teste').val();
       var data_teste_original = $('#subitem-'+$(this).data('subitem')+' #data-teste').data('original');
       var datacomentario = $('#subitem-'+$(this).data('subitem')+' #data-teste').data('comentario');
       
       data_subitem = JSON.stringify({id:id,situacao:situacao,judge:judge,data_teste:data_teste,data_original:data_teste_original,comentario:datacomentario});
       $.ajax({
                url: '?r=itemassurance/atualizarsubitem',
                type: 'post',
                datatype: 'json',
                contentType: "application/json; charset=utf-8",
                data:data_subitem,
                success: function (data) {
                    alert("Atualizado com sucesso!");
                },
                error: function(xhr, ajaxOptions, thrownError){
                    alert(thrownError);
                }
        });
               
   });  

   $(document).on('change','#data-teste',function(){ 
       id = $(this).data('subitem');
       
       $('#comentario-text').val("");
        var popup = $('#popup_subitem');
        //popup.find('.modal-title').text('New message to ' + recipient);
        //popup.find('.modal-body input').val(recipient);
        popup.modal('show');

   });

    $(document).on('click','#ok-popup',function(){   
      $('#subitem-'+ id +' #data-teste').data('comentario',$('#comentario-text').val()); 
   });


JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position); 
?>
<br>
<div class="item-assurance-view">

     <div class="box box-danger container">
        <div class="box-header with-border">
            <br>
                <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <p>
                <!--<?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>-->
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
        </p>

        <!-- <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'nome',
                    'judge',
                    'assurance',
                    'situacao',
                ],
         ]) ?> -->
        <br>
        <div id="subitems">
            <?php echo $subitems?>
        </div>

    </div>

    <div class="modal fade" id="popup_subitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="exampleModalLabel">Data Teste</h4>
          </div>
          <div class="modal-body">
            
            <div class="form-group">
                <label for="message-text" class="col-form-label">Comentário:</label>
                <textarea class="form-control" id="comentario-text"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" id="ok-popup">OK</button>
            <!--<button type="button" class="btn btn-primary">Send message</button> -->
          </div>
        </div>
      </div>
    </div>
</div>
