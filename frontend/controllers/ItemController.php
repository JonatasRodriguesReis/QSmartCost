<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\helpers\Json;
use common\models\ItemSearch;
use frontend\controllers\StatusrohsController;
use common\models\statusrohs;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/*update subitem set operator = 'Claudia', judge = 'O.K.' where item = (select id from item where nome = 'ABW73152517' and data_teste = '2018-10-4') and nome = 'Surface';    update item set situacao = 'REALIZADO' where nome = 'ABW73152517' and data_teste = '2018-10-4';
update subitem set operator = 'Claudia', judge = 'O.K.' where item = (select id from item where nome = 'ABW73152517' and data_teste = '2018-10-4') and nome = 'Insulator 1';    
update subitem set operator = 'Claudia', judge = 'O.K.' where item = (select id from item where nome = 'ABW73152517' and data_teste = '2018-10-4') and nome = 'Insulator 2';    
update subitem set operator = 'Claudia', judge = 'O.K.' where item = (select id from item where nome = 'ABW73152517' and data_teste = '2018-10-4') and nome = 'Tape';   */

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [  'update','delete','create'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update','delete','create'],
                        'roles' => ['@'],
                    ],
                ],
                
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$idstatus)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),'subitems' => $this->subitems($id,$this->findModel($id)['situacao'],$this->findModel($id)['nome']),'idstatus'=>$idstatus
        ]);
    }

    private function subitems($id,$situacao,$nome){
        $connection = Yii::$app->getDb();

    
        $command = $connection->createCommand("SELECT * FROM subitem WHERE item = " . $id);

        $result = $command->queryAll();

        $htm = '';

        if($situacao == 'NÃO_REALIZADO'){
            $aux = 'disabled';
            
        }else{
            $aux = '';
            $htm = '<thead style="background-color:#696969;color:#fff;text-align:center;"><tr style="font-size:16px;"><th style="text-align:center;">Sample name</th><th>Recipe Name</th><th>Cd Conc</th><th>Pb Conc</th><th>Hg Conc</th><th>Br Conc</th><th>Cr Conc</th><th></th></tr></thead>';
            $htm = $htm.'<tbody>';
            foreach ($result as $item) {
                $htm = $htm.'<tr><td style="text-align:center;vertical-align:middle;font-size:16px;"><b>'. $item['nome'] . '</b>';

                $htm = $htm.'<td style="text-align:center;vertical-align:middle;font-size:16px;"><b >'. $item['recipe_name'] . '</b>';

                if($item['cd_conc'] < 80) $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #32f032;border-radius: 8px;vertical-align:middle; padding-top:16px;"><b>'. $item['cd_conc'] .'</b></div></td>';
                else $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #f00f0f;border-radius: 8px;vertical-align:middle; padding-top:16px;color:white;"><b>'. $item['cd_conc'] .'</b></div></td>';
                if($item['pb_conc'] < 800) $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #32f032;border-radius: 8px;vertical-align:middle; padding-top:16px;"><b>'. $item['pb_conc'] .'</b></div></td>';
                else $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #f00f0f;border-radius: 8px;vertical-align:middle; padding-top:16px;color:white;"><b>'. $item['pb_conc'] .'</b></div></td>';
                if($item['hg_conc'] < 800) $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #32f032;border-radius: 8px;vertical-align:middle; padding-top:16px;"><b>'. $item['hg_conc'] .'</b></div></td>';
                else $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #f00f0f;border-radius: 8px;vertical-align:middle; padding-top:16px;color:white;"><b>'. $item['hg_conc'] .'</b></div></td>'; 
                if($item['br_conc'] < 800) $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #32f032;border-radius: 8px;vertical-align:middle; padding-top:16px;"><b>'. $item['br_conc'] .'</b></div></td>';
                else $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #f00f0f;border-radius: 8px;vertical-align:middle; padding-top:16px;color:white;"><b>'. $item['br_conc'] .'</b></div></td>';
                if($item['cr_conc'] < 800) $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #32f032;border-radius: 8px;vertical-align:middle; padding-top:16px;"><b>'. $item['cr_conc'] .'</b></div></td>';
                else $htm = $htm.'<td><div style="height:50px; text-align:center;background-color: #f00f0f;border-radius: 8px;vertical-align:middle; padding-top:16px;color:white;"><b>'. $item['cr_conc'] .'</b> </div></td>';
				
                $htm = $htm.'</a></td><td><a href = "'. Url::to('/ReportsFiles/' ) . $item['data_teste'] . '_'. $item['sample_no'] .'_'. $item['nome'] .'_' .$nome .'.xls"><button class="btn btn-primary"'. $aux .'>Report</button></a></td></tr>';

                    /*$htm = $htm.'<tr><td><a><h5>'. $item['nome'] . '</h5></a></td><td><a href = "http://localhost:85/QSmartCost/exportarPDF.php?nome=' . $item['data_teste'] . '_'. $item['sample_no'] .'_'. $item['nome'] .'_' .$nome .'.html"><button class="btn btn-primary"'. $aux .'>Report</button></a></td></tr>';*/
            }
            $htm = $htm.'</tbody>';
        }

        
        
       

      return $htm ;
    }

    /**
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionGet()
    {
        if (Yii::$app->request->isAjax) {

            $data = file_get_contents("php://input");
            //'{"teste":"teste","month":[{"nome":"jon1"},{"nome":"jon2"}]}'

            $json_obj = Json::decode($data,false);
            echo($json_obj->id);
           /* //echo($json_obj['items'][3]['nome']);
            //echo(sizeof($json_obj['items']));
            //echo($json_obj['month']);
            
            $model = new statusrohs();
            $model->status = 'PENDING';
            $model->month = $json_obj['month'];
            $model->save();

            for ($i=0; $i < sizeof($json_obj['items']); $i++) { 
                $modelItem = new Item();
                $modelItem->situacao = 'NÃO_REALIZADO';
                $modelItem->nome = $json_obj['items'][$i]['nome'];
                $modelItem->data_teste = $json_obj['items'][$i]['data'];
                $modelItem->statusrohs = $model->id;

                $modelItem->save();
            }

            //echo $model->id;
            return $this->redirect(['view', 'id' => $model->id]);*/
        }
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id,$idstatus)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'idstatus' => $idstatus]);
            //return $this->render('//statusrohs/view',['model' => statusrohs::findOne($idstatus),'teste' => StatusrohsController::teste($idstatus,StatusrohsController::findModel($idstatus))['month']]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatedata()
    {
        if (Yii::$app->request->isAjax) {

            $data = file_get_contents("php://input");
            $json_obj = Json::decode($data);
            $connection = Yii::$app->getDb();
            $sql = "update item set data_teste = '". $json_obj['data'] ."' WHERE id = " . $json_obj['id'];
            
            $command = $connection->createCommand($sql)->execute();


            $command = $connection->createCommand("insert into data_teste_old(data_old,item,comentario) values('".$json_obj['data_old'] ."',". $json_obj['id'] .",'". $json_obj['item_comentario'] ."')")->execute();

        }
    }

    /**
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
