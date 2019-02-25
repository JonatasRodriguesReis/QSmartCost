<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use common\models\statusrohs;
/* @var $this yii\web\View */
/* @var $model common\models\Item */



$this->title = $model->nome;
$this->params['breadcrumbs'][] = ['label' => 'StatusRoHS', 'url' => ['statusrohs/index']];
$this->params['breadcrumbs'][] = ['label' => statusrohs::findOne($idstatus)['month'], 'url' => ['statusrohs/view' , 'id'=> $idstatus ]];
//$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$script = <<< JS

  var th = $('.table-fixed').find('thead th');
    $('.table-fixed').on('scroll', function() {
      th.css('transform', 'translateY('+ this.scrollTop +'px)');
    });


$('#popup_subitem').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var recipient = button.data('nome');
    var modal = $(this);
    modal.find('#item-nome').text(recipient);
      
    modal.find('#fileToUpload').html("<form id = 'form-file-"+ id +"' method='post' enctype='multipart/form-data'><div class='form-group'><label for='up-relatorio'>Upload Relatório</label><input type='file' class='form-control-file' id='up-relatorio' name='fileToUpload[]' multiple accept='application/pdf,application/vnd.ms-excel'></div></form><button class='btn btn-success btn-atualizar' data-subitem='"+ id +"' >Atualizar</buttom>");

    $.ajax({
        url: '?r=item/getreports&id='+id,
        success: function (data) {
            modal.find('.modal-body #div-reports').html(data);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(thrownError);
        }
    });
      
 });

  $(document).on('click','.btn-atualizar',function(){
       var id = $(this).data('subitem'); 
       //alert('?r=item/atualizarsubitemarquivo&id='+id);     
       var formData = new FormData($('#form-file-'+id)[0]);
        $.ajax({
            url: '?r=item/atualizarsubitemarquivo&id='+id,
            type: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,                        
            success: function (result) {
                if(result == "" || result == "Nada"){
                    alert('Relatório não adicionado!');
                }else
                    if(result == "OK"){
                        alert('Relatório adicionado com sucesso!');
                    }
            },
            error: function(xhr, ajaxOptions, thrownError){
                alert(thrownError);
            }
         });

   });  

JS;
$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);  
$this->registerCss('


.table-fixed { overflow-y: auto; height: 450px; }

/* Just common table stuff. */
.table-fixed table  { border-collapse: collapse; width: 100%; }
.table-fixed th { padding: 8px 16px; }

.table-fixed th { background-color:#696969;color:#fff; }

'); 
?>
<br>
<div class="item-view">

    <div class="box box-danger container">
        <div class="box-header with-border">
        <br>
            <h1><?= Html::encode($this->title) ?></h1>
        </div>

        <?php if($model->situacao == 'NÃO_REALIZADO' && $model->comentario != ''){
                echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'comentario'
                ],
              ]);
            }

            if($model->situacao == 'REALIZADO' ){
                echo '<b>' . DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'part_number'
                ],
              ]) . '</b>';
            }
            /*else{
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
        ?>

        <p>
            <?= Html::a('Update', ['update', 'id' => $model->id,'idstatus' => $idstatus], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </p>

        <div class="table-fixed">
            <table id="days-header" class="table  table-striped table-hover ">

                <?php echo $subitems?>
            </table>
        </div>

         <div class="modal fade" id="popup_subitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="item-nome">SubItem</h4>
              </div>
              <div class="modal-body">                  

                <div style = "float:right;" id="div-reports">
                   <!--<a href= <?php echo  Url::to('/ReportsFiles/' ) . "Boleto1.pdf"; ?> target="_blank">
                        <img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/pdf-icon.svg"; ?> > 
                    </a>
                   <a href="#"><img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/excel-icon.svg"; ?>> </a>
                   <a href="#"><img style="height: 25px;width: 50px;" src= <?php echo Yii::$app->request->baseUrl . "/img/powerpoint-icon.svg"; ?>> </a> -->
                </div>

                <div id = "fileToUpload">
                    
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
</div>
