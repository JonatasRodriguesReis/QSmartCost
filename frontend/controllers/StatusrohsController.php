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
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionGetmonthschart($ano){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT * FROM statusrohs where month like '%". substr($ano,-2) ."' order by id desc");

        $result = $command->queryAll();
        $lista = array();
        foreach ($result as $perk) {
            $month = array(
                "month" => $perk['month'],
                "plan" =>  $this->getNumPlan($perk['id']),
                "result" => $this->getNumResult($perk['id']),
                "numcluido" => $this->getNumConcluido($perk['id'])
            );
            array_push($lista, $month);
        }

        return json_encode($lista);
    }

    public function actionGetmonths($ano){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT * FROM statusrohs where month like '%". substr($ano,-2) ."' order by id asc");
        $result = $command->queryAll();
        $html = '<div class="container table-responsive" style="width: 100%;">
            
                    <table class="table  table-striped table-hover ">';
                
        $html .= '<thead style="background-color:#696969;color:#fff;">
                    <tr >
                        <th style="text-align:center;padding-top:14px;padding-bottom:14px; vertical-align:middle;"></th>
            ';
        $array = [
                "JAN","FEV","MAR","ABR","MAI" ,"JUN","JUL","AGO","SET","OUT",
                "NOV","DEZ"
            ];
        for ($j=0; $j < 12; $j++) { 
            $html .= '<th style="text-align:center;padding-top:14px;padding-bottom:14px; vertical-align:middle;">';
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<a href='. Url::to('?r=statusrohs/view&id='. $perk['id'] ) .' style = "color:#fff">'. $array[$j]. '\''. substr($ano,-2) .'</a>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= $array[$j]. '\''. substr($ano,-2);
            }
            $html .= '</th>';
        }
        $html .= '</tr></thead>
            <tbody>
                <tr><td style="font-size:16px;padding-top:14px;padding-bottom:14px;"><b>Progress</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">
                              <div class="progress" style = "margin-left: 16px; margin-right: 16px;">
                                  <div class="progress-bar  " role="progressbar" style="color:#000000;background-color: #32f032;width:'. $this->getNumConcluido($perk['id']) .'%;" aria-valuenow="'. $this->getNumConcluido($perk['id']) .'" aria-valuemin="0" aria-valuemax="100">'.$this->getNumConcluido($perk['id']).'%</div>
                              </div></td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center">-</td>';
            }
        }
        $html .= '</tr><tr><td style="font-size:16px;padding-top:14px;padding-bottom:14px;"><b>Plan</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">'. $this->getNumPlan($perk['id']) .'</td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center">-</td>';
            }
        }
        $html .= '</tr>';
        $html .= '<tr><td style="font-size:16px;padding-top:14px;padding-bottom:14px;"><b>Result</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">'. $this->getNumResult($perk['id']) .'</td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center">-</td>';
            }
        }
        $html .= '</tr>';    
        $html .= '<tr><td style="color: #32f032;font-size:16px;padding-top:14px;padding-bottom:14px;"><b>OK</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #32f032"><b>'. $this->getNumOK($perk['id']) .'</b></td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center;color: #32f032"><b>-</b></td>';
            }
        }
        $html .= '</tr>'; 
        $html .= '<tr><td style="color: #f00f0f;font-size:16px;padding-top:14px;padding-bottom:14px;"><b>NG</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #f00f0f"><b>'. $this->getNumNG($perk['id']) .'</b></td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center;color: #f00f0f"><b>-</b></td>';
            }
        }
        $html .= '</tr>';
        $html .= '<tr><td style="color: #f00f0f;font-size:16px;padding-top:14px;padding-bottom:14px;"><b>NG%</b></td>';
        for ($j=0; $j < 12; $j++) { 
            $achou = false;
            foreach ($result as $perk) {
                if(substr($perk['month'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #f00f0f"><b>'. $this->getNumNGPorcentagem($perk['id']) .'%</b></td>';
                    $achou = true;
                    break;
                }
            }
            if(!$achou){
                $html .= '<td style="text-align:center;color: #f00f0f"><b>-</b></td>';
            }
        }
        $html .= '</tr>';     
        $html .= '</tbody></table>
                </div>';
        
        
        /*$html = '';
        foreach ($result as $perk) {
            $html .= '<div class="col-sm-2">
                        <div class="thumbnail" style="width: 15rem;">
                          
                          <div class="caption">
                            <div class="progress" style = "margin-left: 16px; margin-right: 16px;">
                              <div class="progress-bar  " role="progressbar" style="background-color: #32f032;width:'. $this->getNumConcluido($perk['id']) .'%;" aria-valuenow="'. $this->getNumConcluido($perk['id']) .'" aria-valuemin="0" aria-valuemax="100">'.$this->getNumConcluido($perk['id']).'%</div>
                            </div>
                            <h5 class="card-title" style="text-align:center;"><b>'. str_replace("'","' ",$perk['month']).'</b></h5>
                            
                            <a href='. Url::to('?r=statusrohs/view&id='. $perk['id'] ) .' style = "margin-left:1.8rem;"><button class="btn btn-default"><span class="fa fa-eye"></span></button></a>
                            <a href='. Url::to('?r=statusrohs/delete&id='. $perk['id'] ) .' data-confirm="Tem certeza que deseja apagar '. $perk['month'] .'?" data-method="post"><button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span></button></a>
                          </div>
                        </div>
                     </div>';
            
        }*/
        return $html;
    }


    public function actionGetanos(){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT DISTINCT year(data_teste) as ano FROM item ORDER BY year(data_teste) DESC");

        $result = $command->queryAll();
        $html = '<select  class="form-control" style = "width: 15%;">';
        foreach ($result as $perk) {
            $html .= '<option>'. $perk['ano'] .'</option>';
        }
        $html .= '</select><br><br>';
        //$html .= '<div id="grafico" style="padding: 0px; width: 100%; height: 300px;"></div>';
        $html .= '<div id="cards" class="row">'. $this->actionGetMonths($result[0]['ano']) . '</div>';

        return $html;
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
            'model' => $this->findModel($id),'items' => $this->getItems($id,$this->findModel($id)['month']),'numConcluido' => $this->getNumConcluido($id),'numPlan' => $this->getNumPlan($id),'numResult' => $this->getNumResult($id)
        ]);
    }

    public function getNumConcluido($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE situacao = 'REALIZADO'and statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }

        return ceil((($totalRealizado*100)/$total));
    }

    public function getNumPlan($id){

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        return $total;
    }

    public function getNumResult($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE situacao = 'REALIZADO'and statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }

        return $totalRealizado;
    }

    public function getNumOK($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE judge = 'O.K.'and statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalOK = $perk['COUNT(id)'];
            break;
        }

        return $totalOK;
    }

    public function getNumNG($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE judge = 'N.G.'and statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalNG = $perk['COUNT(id)'];
            break;
        }

        return $totalNG;
    }

    public function getNumNGPorcentagem($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        $command = $connection->createCommand("SELECT COUNT(id) FROM item WHERE judge = 'N.G.' and statusrohs = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }

        return ceil((($totalRealizado*100)/$total));
    }

    public function getItems($id,$month){
        $connection = Yii::$app->getDb();

    
        $command = $connection->createCommand("SELECT * FROM item WHERE statusrohs = " . $id);

        $result = $command->queryAll();

        /*$items = array();
        foreach ($result as $item) {
           $array_push($items,['COUNT(item)']);
        }*/

            $list = $this->getDatas($month);

            //$htm= '<table class="table table-bordered" ><tr>';
            $htm = '<thead style="background-color:#696969;color:#fff;">
                    <tr >
                        <th style="text-align:center; width:200px;padding:8px 0px 8px 0px;">Item</th><th style="text-align:center;">Judge</th>
            ';

            $dias_total = array();
            $datas_total = array();
            foreach ($list as $data) {
                //print_r(substr($data,-3));
                //if(!(substr($data,-3) == 'Sun' || substr($data,-3) == 'Sat')){
                    $htm = $htm . '<th style="text-align:center;padding-left:5px; padding-right:5px;">'. substr($data, -6,-4) .'</th>';
                    //print_r($data." ");
                    array_push($dias_total,substr($data, -6,-4));
                    array_push($datas_total,substr($data,0,-4));
                //}
                
            }

            $htm = $htm.'</tr></thead><tbody>';

            foreach ($result as $item) {

                $command = $connection->createCommand("SELECT * FROM data_teste_old WHERE item = " . $item['id']);

                $datas_old_result = $command->queryAll();

                $htm = $htm . '<tr><td style="min-width: 100px;max-width:150px;padding:8px 0px 8px 0px;"><b><a style="font-size:16px;color:#000000;" class = "botao-item" href="'. Url::to('?r=item/view&id='. $item['id'] ) .'&idstatus='. $id .'">' . $item['nome'] . ' </a></b></td>';

                if($item['situacao'] == "REALIZADO"){
                    if($item['judge'] == "O.K."){  

                       $htm = $htm . '<td style="vertical-align:middle;"><div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #32f032; border-radius:8px;height: 25px;"><b>'. str_replace(".","",$item['judge']) .'</b></div></td>';
                    }else{
                       $htm = $htm . '<td style="vertical-align:middle;"><div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #f00f0f; border-radius:8px;height: 25px;color:white;">'. str_replace(".","",$item['judge']) .'</b></div></td>';

                    }
                    
                }else{
                    $htm = $htm . '<td></td>';
                }

                $i = 0;
                foreach ($dias_total as $dia) {
                    
                    if($datas_total[$i] == $item['data_teste']){
                        if($item['situacao'] == 'REALIZADO'){
                             $htm = $htm .'
                                <td style="vertical-align:middle; padding:0px;">
                                    <button type="button" class="btn example-popover" styledata-container="body" style = "background-color: #32f032;height: 25px; width:100%;border-radius: 50px;" data-placement="top" data-content="">
                                    </button>  
                                </td>
                            ';
                        }else{
                            $htm = $htm .'
                                <td style="vertical-align:middle; padding:0px;">
                                    <button type="button" class="btn example-popover" styledata-container="body" style = "height: 25px ;width:100%;border-radius: 50px;background-color:#CCCCCC;" data-toggle="popover" data-placement="top" data-content="'. $item['comentario'] . '">
                                    </button>
                                </td>
                            ';
                        }
                    }else{
                        $achou = false;
                        foreach ($datas_old_result as $data_old) {
                            if($datas_total[$i] == $data_old['data_old']){
                                $achou = true;
                                 $htm = $htm .'
                                    <td style="vertical-align:middle;padding:0px;">
                                        <button type="button" class="btn example-popover" styledata-container="body" style = "height: 25px ;width:100%;border-radius: 50px; background-color: #696969;" data-toggle="popover" data-placement="top" data-content="'. $data_old['comentario'] . '">
                                        </button>
                                    </td>
                                ';
                                break;
                            }
                        }
                        if(!$achou){
                            $htm = $htm .'
                                <td>
                                </td>
                            ';
                        }
                        
                    }
                    $i++;
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

            for ($i=0; $i < sizeof($json_obj['items']); $i++) { 
                $modelItem = new Item();
                $modelItem->situacao = 'NÃO_REALIZADO';
                $modelItem->nome = $json_obj['items'][$i]['nome'];
                $modelItem->data_teste = $json_obj['items'][$i]['data'];
                $modelItem->statusrohs = $model->id;

                $modelItem->save();

                /*foreach ($items[$json_obj['items'][$i]['nome']] as $subitem) {
                    $modelSubitem = new Subitem();
                    $modelSubitem->nome = $subitem;
                    $modelSubitem->data_teste = $json_obj['items'][$i]['data'];
                    $modelSubitem->item = $modelItem->id;

                    $modelSubitem->save();
                }*/

            }

            
            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    private function getDatas($input){
            $month = substr($input, 0,-3);
            $year = substr($input, 4);

            $array = [
                "JAN" => "01","FEV" => "02","MAR"=>"03","ABR" => "04","MAI" => "05","JUN"=>"06","JUL"=>"07  ","AGO"=>"08","SET"=>"09","OUT"=>"10",
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
            //$items = array('ABW73152517','ABW73152518','Cover','Fan Assy Propeller');
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("SELECT nome FROM item_nome where 1");
            $result = $command->queryAll();
            $items = array();
            foreach ($result as $item) {
               array_push($items,$item['nome']);
            }

            
            foreach ($items as $key) {
                $trim = str_replace(" ","",$key);
                $trim = str_replace(",","",$trim);
                $htm = $htm . '<tr><td data-nome = "'. $trim .'">' . $key . '</td>';
                $i = 0;
                foreach ($dias_total as $dia) {
                    $htm = $htm .'
                        <td>
                            <div class="radio">
                                <label>
                                  <input type="radio" name="radios_'. $trim  .'" id="radio_' . $key.'" value="'. $dia .'" data-date="'. $datas_total[$i] .'">
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
