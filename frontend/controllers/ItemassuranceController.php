<?php

namespace frontend\controllers;

use Yii;
use common\models\ItemAssurance;
use common\models\ItemassuranceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * ItemassuranceController implements the CRUD actions for ItemAssurance model.
 */
class ItemassuranceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ItemAssurance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemassuranceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemAssurance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$idAssurance)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),'subitems' => $this->subitems($id,$this->findModel($id)['situacao'],$this->findModel($id)['nome']),'idassurance'=>$idAssurance
        ]);
    }

    private function subitems($id,$situacao,$nome){
        $connection = Yii::$app->getDb();

    
        $command = $connection->createCommand("SELECT * FROM subitem_assurance WHERE item_assurance = " . $id);

        $result = $command->queryAll();

        $htm = '';

        
        foreach ($result as $subitem) {   
            if($subitem['situacao'] == "REALIZADO"){
                $opcoes = '<option>NÃO REALIZADO</option>
                           <option selected >REALIZADO</option>';
                
            }
            else{
                $opcoes = '<option selected>NÃO REALIZADO</option>
                                  <option >REALIZADO</option>';
                        
            }
            if($subitem['judge'] == "OK"){
                    $opcoes_judge = '<div class="form-group col-sm-2">
                                        <label for="select-situacao">Judge</label>
                                        <select class="form-control" id="select-judge"> 
                                          <option selected>OK</option>
                                          <option>NG</option>
                                         </select>
                                     </div>'; 

            }else{
                    $opcoes_judge = '<div class="form-group col-sm-2">
                                        <label for="select-situacao">Judge</label>
                                        <select class="form-control" id="select-judge"> 
                                          <option>OK</option>
                                          <option selected>NG</option>
                                         </select>
                                    </div>'; 
            }
            $htm .= '<div class="panel panel-default">
                        <div class="panel-heading" style="background-color:#696969;color:#fff;">
                            <h3 class="panel-title"><b>'. $subitem['nome'] .'</b></h3>
                        </div>
                        <div class="panel-body" id="subitem-'. $subitem['id'] .'">
                            <div class="form-group col-sm-3">
                                <label for="select-situacao">Situação</label>
                                <select class="form-control" id="select-situacao">'.
                                  $opcoes                                  
                                .'</select>
                            </div>'.
                                  $opcoes_judge                                  
                                .'
                            <div class="form-group col-sm-3">
                              <label for="data_teste" class="col-2 col-form-label">Data de Teste</label>
                              <div class="col-10">
                                <input class="form-control" type="date" value="'. $subitem['data_teste'] .'" id="data-teste" data-original="'. $subitem['data_teste'] .'" data-comentario="" data-subitem="'. $subitem['id'] .'">
                              </div>
                            </div>
                            
                            <form id = "form-file-'. $subitem['id'] .'"method="post" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="up-relatorio">Upload Relatório</label>
                                <input type="file" class="form-control-file" id="up-relatorio" name="fileToUpload[]" multiple accept="application/pdf">
                              </div>
                            </form>

                            <button class="btn btn-success btn-atualizar" data-subitem="'. $subitem['id'] .'" style="float:right;">Atualizar</buttom>
                        </div>
                      </div>';
        }
        
        return $htm ;
    }

    /**
     * Creates a new ItemAssurance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemAssurance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ItemAssurance model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ItemAssurance model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ItemAssurance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemAssurance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemAssurance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAtualizarsubitem()
    {
        
        if (Yii::$app->request->isAjax) {
            $t = Yii::$app->request->post();
            $situacao = $t['situacao'];
            $judge = $t['judge'];
            $data_teste = $t['data_teste'];
            $id = $t['id'];
            $data_original = $t['data_original'];
            $comentario = $t['comentario'];
            $connection = Yii::$app->getDb();
            $sql = "Update subitem_assurance set situacao = '" . $situacao ."', judge='". $judge ."', data_teste='". $data_teste ."' where id = ".$id;
            if($data_teste != $data_original and $comentario != ""){
                $command = $connection->createCommand("insert into data_teste_old_assurance(data_old,subitem_assurance,comentario) values('". $data_original ."',". $id .",'". $comentario ."')");
                $command->execute();
            }

            if($data_teste != $data_original and $comentario == ""){
                $sql = "Update subitem_assurance set situacao = '" . $situacao ."', judge='". $judge ."', data_teste='". $data_original ."' where id = ".$id;
            }

            
            $command = $connection->createCommand($sql);
            $command->execute();
        }
    }

    public function actionAtualizarsubitemarquivo($id)
    {
        
        $path = "C:\\xampp\\htdocs\\ReportsFiles\\";
        $result = '';
        $property_images = $_FILES['fileToUpload']['name'];
        if (!empty($property_images)) {
            for ($up = 0; $up < count($property_images); $up++) {
                if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'][$up], $path . str_replace(" ", "_", $_FILES['fileToUpload']['name'][$up]))) {
                    echo $result = "OK";
                    $connection = Yii::$app->getDb();
                    $command = $connection->createCommand("insert into subitem_assurance_report(nome,subitem_assurance) values('". str_replace(" ", "_", $_FILES['fileToUpload']['name'][$up]) ."',". $id .")");
                    $command->execute();
                }
            }
        } else {
            echo $result = "Nada";
        }

        
    }
}
