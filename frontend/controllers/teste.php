<?php

namespace frontend\controllers;

use Yii;
use yii\helpers\Json;
use common\models\statusrohs;
use ItemController;
use common\models\statusrohsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Item;
use common\models\Subitem;
use yii\helpers\Url;

/**
 * StatusrohsController implements the CRUD actions for statusrohs model.
 */
class StatusrohsController extends Controller
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
     * Lists all statusrohs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new statusrohsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single statusrohs model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),'teste' => $this->teste($id,$this->findModel($id)['month'])
        ]);
    }

    public function teste($id,$month){
        $connection = Yii::$app->getDb();

    
        $command = $connection->createCommand("SELECT * FROM item WHERE statusrohs = " . $id);

        $result = $command->queryAll();

        /*$items = array();
        foreach ($result as $item) {
           $array_push($items,['COUNT(item)']);
        }*/

            $list = $this->getDatas($month);

            //$htm= '<table class="table table-bordered" ><tr>';
            $htm = '<thead style="background-color:#b71c1c;color:#fff">
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

            foreach ($result as $item) {
                $htm = $htm . '<tr><td> <a class = "botao-item" href="'. Url::to('?r=item/view&id='. $item['id'] ) .'&idstatus='. $id .'">' . $item['nome'] . ' </a></td>';
                $i = 0;
                foreach ($dias_total as $dia) {
                    
                    if($datas_total[$i] == $item['data_teste']){
                        if($item['situacao'] == 'REALIZADO'){
                             $htm = $htm .'
                                <td>
                                    <button type="button" class="btn btn-success example-popover" styledata-container="body" style = "height: 25px ;border-radius: 50px;" data-placement="top" data-content="">
                                    </button>  
                                </td>
                            ';
                        }else{
                            $htm = $htm .'
                                <td>
                                    <button type="button" class="btn btn-light example-popover" styledata-container="body" style = "height: 25px ;border-radius: 50px;" data-toggle="popover" data-placement="top" data-content="'. $item['comentario'] . '">
                                    </button>
                                </td>
                            ';
                        }
                    }else{

                        $htm = $htm .'
                            <td>

                                
                            </td>
                        ';
                    }
                    $i = $i + 1;
                }
                $htm = $htm . '</tr>';
            }
            $htm = $htm.'</tbody>';
            
           

        return $htm ;
    }

    /**
     * Creates a new statusrohs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new statusrohs();
		$model->status = 'PENDING';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    public function actionCreate2()
    {
        if (Yii::$app->request->isAjax) {

            $data = file_get_contents("php://input");
            //'{"teste":"teste","month":[{"nome":"jon1"},{"nome":"jon2"}]}'

            $json_obj = Json::decode($data);
            //echo($json_obj['items'][3]['nome']);
            //echo(sizeof($json_obj['items']));
            //echo($json_obj['month']);
            
            $model = new statusrohs();
            $model->status = 'PENDING';
            $model->month = $json_obj['month'];
            $model->save();

            $items = array(
                'ABW73152517' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Chassis Assembly' => array('SubItem1','SubItem2','SubItem3','SubItem4'),
                'Cover' => array('SubItem1','SubItem2','SubItem3','SubItem4'),
                'Fan Assy Propeller' => array('SubItem1','SubItem2','SubItem3','SubItem4'),
                /*'Grille Assy Front' => array('SubItem1','SubItem2','SubItem3','SubItem4'),
                'Damper Butyl' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Tube Assembly,Reverse
l' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'PCB Assembly 
' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Panel Assembly Front(Outdoor)
' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Remote Controller Assembly' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Plate Assembly,Installation' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Reactor, Transformer' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Motor AC' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Motor Assembly,AC,Outdoor' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Fan Assembly,Cross Flow' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Ionizer, Generator' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Ionizer, Generator' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Case Assembly,Control(Outdoor)' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Motor Assembly,DC,Indoor' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Valve,Reverse' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Valve,Service' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Tube Assembly,Tubing' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Parafuso' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Harness,Multi
' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Base Assembly,Outdoor' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Insulator
' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Bracket,Motor
' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Panel,Control' => array('Surface','Insulator 1','Insulator 2','Tape'),
                'Orifice' => array('Surface','Insulator 1','Insulator 2','Tape'), 
                'Case Assembly,Control(Indoor)' => array('Surface','Insulator 1','Insulator 2','Tape'),*/
            );

            for ($i=0; $i < sizeof($json_obj['items']); $i++) { 
                $modelItem = new Item();
                $modelItem->situacao = 'NÃO_REALIZADO';
                $modelItem->nome = $json_obj['items'][$i]['nome'];
                $modelItem->data_teste = $json_obj['items'][$i]['data'];
                $modelItem->statusrohs = $model->id;

                $modelItem->save();

                foreach ($items[$json_obj['items'][$i]['nome']] as $subitem) {
                    $modelSubitem = new Subitem();
                    $modelSubitem->nome = $subitem;
                    $modelSubitem->data_teste = $json_obj['items'][$i]['data'];
                    $modelSubitem->item = $modelItem->id;

                    $modelSubitem->save();
                }

            }

            //echo $model->id;
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    private function getDatas($input){
            $month = substr($input, 0,-3);
            $year = substr($input, 4);

            $array = [
                "JAN" => "01","FEV" => "02","MAR"=>"03","ABR" => "04","MAI" => "05","JUN"=>"06","JUL"=>"07","AGO"=>"08","SET"=>"09","OUT"=>"10",
                "NOV" => "11","DEZ"=>"12"
            ];


            $start_date = "01-".$array[$month]."-20".$year;
            $start_time = strtotime($start_date);

            $end_time = strtotime("+1 month", $start_time);

            for($i=$start_time; $i<$end_time; $i+=86400)
            {
               $list[] = date('Y-m-d-D', $i);
            }  

            return $list;  
    }

    public function actionDatas()
    {
        
        if (Yii::$app->request->isAjax) {
            $t = Yii::$app->request->post();
            $input = $t['month'];
            
            $list = $this->getDatas($input);

            //$htm= '<table class="table table-bordered" ><tr>';
            $htm = '<thead style="background-color:#b71c1c;color:#fff">
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

            $items = array(
                'ABW73152517',
                'Chassis Assembly' ,
                'Cover',
                'Fan Assy Propeller' ,
                /*'Grille Assy Front' ,
                'Damper Butyl' ,
                'Tube Assembly,Reverse
l',
                'PCB Assembly',
                'Panel Assembly Front(Outdoor)',
                'Remote Controller Assembly' ,
                'Plate Assembly,Installation' ,
                'Reactor, Transformer' ,
                'Motor AC',
                'Motor Assembly,AC,Outdoor' ,
                'Fan Assembly,Cross Flow' ,
                'Ionizer, Generator' ,
                'Ionizer, Generator' ,
                'Case Assembly,Control(Outdoor)' ,
                'Motor Assembly,DC,Indoor' ,
                'Valve,Reverse' ,
                'Valve,Service' ,
                'Tube Assembly,Tubing' ,
                'Parafuso' ,
                'Harness,Multi',
                'Base Assembly,Outdoor' ,
                'Insulator
' ,
                'Bracket,Motor
' ,
                'Panel,Control' ,
                'Orifice' , 
                'Case Assembly,Control(Indoor)' ,*/
            );
            foreach ($items as $key) {
                $htm = $htm . '<tr><td>' . $key . '</td>';
                $i = 0;
                foreach ($dias_total as $dia) {
                    $htm = $htm .'
                        <td>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="radios_'. $key .'" id="radio_' . $key.'" value="'. $dia .'" data-date="'. $datas_total[$i] .'">
                                </label>
                            </div>
                        </td>
                    ';
                    $i = $i + 1;
                }
                $htm = $htm . '</tr>';
            }
            $htm = $htm.'</tbody>';
            echo $htm;
        }
    }


    /**
     * Updates an existing statusrohs model.
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
     * Deletes an existing statusrohs model.
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
     * Finds the statusrohs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return statusrohs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id)
    {
        if (($model = statusrohs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
