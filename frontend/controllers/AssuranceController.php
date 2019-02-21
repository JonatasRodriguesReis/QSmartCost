<?php

namespace frontend\controllers;

use Yii;
use common\models\Assurance;
use common\models\AssuranceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * AssuranceController implements the CRUD actions for Assurance model.
 */
class AssuranceController extends Controller
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
     * Lists all Assurance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AssuranceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Assurance model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),'items' => $this->getItems($id,$this->findModel($id)['plan']),'numConcluido' => $this->getNumConcluido($id),'numPlan' => $this->getNumPlan($id),'numResult' => $this->getNumResult($id)
        ]);
    }

    public function getItems($id,$plan){
        $connection = Yii::$app->getDb();

    
        $command = $connection->createCommand("SELECT * FROM item_assurance WHERE assurance = " . $id);

        $result = $command->queryAll();

        /*$items = array();
        foreach ($result as $item) {
           $array_push($items,['COUNT(item)']);
        }*/

            $list = $this->getDatas($plan);

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

                $command_subitems = $connection->createCommand("SELECT * FROM subitem_assurance WHERE item_assurance = " . $item['id']);

                $subitems = $command_subitems->queryAll();

                $htm = $htm . '<tr><td style="min-width: 100px;max-width:150px;padding:8px 0px 8px 0px; vertical-align:middle;text-align:center;" rowspan = "'. count($subitems). '"><b><a style="font-size:16px;color:#000000;" class = "botao-item" href="'. Url::to('?r=itemassurance/view&id='. $item['id'] ) .'&idAssurance='. $id .'">' . $item['nome'] .  ' </a></b></td>';

                if($item['situacao'] == "REALIZADO"){
                    if($item['judge'] == "O.K."){  

                       $htm = $htm . '<td style="vertical-align:middle;" rowspan = "'. count($subitems). '"><div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #32f032; border-radius:8px;height: 25px;"><b>'. str_replace(".","",$item['judge']) .'</b></div></td>';
                    }else{
                       $htm = $htm . '<td style="vertical-align:middle;" rowspan = "'. count($subitems). '"><div style="padding-top:2px;text-align:center;vertical-align:middle;background-color: #f00f0f; border-radius:8px;height: 25px;color:white;">'. str_replace(".","",$item['judge']) .'</b></div></td>';

                    }
                    
                }else{
                    $htm = $htm . '<td rowspan = "'. count($subitems). '"></td>';
                }
                $j = 0;
                if(count($subitems) == 0){
                    foreach ($dias_total as $dia) {
                        $htm = $htm .'
                                    <td style="height: 25px ;">
                                     
                                    </td>
                                ';

                    }
                    
                }else{
                    foreach ($subitems as $subitem) {

                        $command = $connection->createCommand("SELECT * FROM data_teste_old_assurance WHERE subitem_assurance = " . $subitem['id']);

                        $datas_old_result = $command->queryAll();
                        
                        if($j != 0){
                            $htm .= '<tr>';    
                        }
                        $i = 0;
                        foreach ($dias_total as $dia) {
                            
                            if($datas_total[$i] == $subitem['data_teste']){
                                if($subitem['situacao'] == 'REALIZADO'){
                                     $htm = $htm .'
                                        <td style="vertical-align:middle; padding:0px;">
                                            <button type="button" class="btn " style = "background-color: #32f032;height: 25px; width:100%;border-radius: 50px;" data-id="'. $subitem['id'] .'" data-nome="'. $subitem['nome'] .'" data-judge="'. $subitem['judge'] .'" data-toggle="modal" data-target="#popup_subitem">
                                            </button>  
                                        </td>
                                    ';
                                }else{
                                    $htm = $htm .'
                                        <td style="vertical-align:middle; padding:0px;">
                                            <button type="button" class="btn example-popover" style = "height: 25px ;width:100%;border-radius: 50px;background-color:#CCCCCC;" data-nome="'. $subitem['nome'] .'">
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
                        
                        if($j != 0){
                          $htm .= '</tr>';
                        }

                        $j++;
                    }
                }               

                
                $htm = $htm . '</tr>';
            }
            $htm = $htm.'</tbody>';
            
           

        return $htm ;
    }

    private function getMes($mes){
         $array = [
                 "1"=> "JAN","2" => "FEV","3"=>"MAR","4" => "ABR","5" => "MAI","6"=>"JUN","7"=>"JUL  ","8"=>"AGO","9"=>"SET","10"=>"OUT",
                "11" => "NOV","12"=>"DEZ"
            ];

        return $array[$mes];
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

    /**
     * Creates a new Assurance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Assurance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Assurance model.
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
     * Deletes an existing Assurance model.
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
     * Finds the Assurance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Assurance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Assurance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionGetmonths($ano){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT * FROM assurance where year(data) = ". $ano ." order by month(data) asc");
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<a href='. Url::to('?r=assurance/view&id='. $perk['id'] ) .' style = "color:#fff">'. $array[$j]. '\''. substr($ano,-2) .'</a>';
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">
                              <div class="progress" style = "margin-left: 16px; margin-right: 16px;">
                                  <div class="progress-bar  " role="progressbar" style="color:#000000;background-color: #32f032;width:' .$this->getNumConcluido($perk['id']) .'%;" aria-valuenow="' .$this->getNumConcluido($perk['id']) .'" aria-valuemin="0" aria-valuemax="100">' .$this->getNumConcluido($perk['id']).'%</div>
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">' .$this->getNumPlan($perk['id']) .'</td>';
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center">'  .$this->getNumResult($perk['id']) .'</td>';
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #32f032"><b>' .$this->getNumOK($perk['id']) .'</b></td>';
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #f00f0f"><b>' .$this->getNumNG($perk['id']) .'</b></td>';
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
                if(substr($perk['plan'],0,3) == $array[$j]){
                    $html .= '<td style="text-align:center;color: #f00f0f"><b>' .$this->getNumNGPorcentagem($perk['id']) .'%</b></td>';
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
    
        return $html;
    }

     public function actionGetanos(){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT Year(data) as ano from assurance group by Year(data)  
            ORDER BY Year(data) desc");

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

    public function actionGerar(){
        $ano_atual = date('Y');
        $mes_atual = date('n');
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT count(id) as datas FROM assurance where year(data) = " . $ano_atual . " and month(data) = " . $mes_atual);
        $result = $command->queryAll();

        foreach ($result as $perk) {
            $datas = $perk['datas'];
            break;
        }

        if($datas == 0){
            $plan = $this->getMes($mes_atual)."''".date('y');;
            $command = $connection->createCommand("INSERT into assurance(plan,data) values('".$plan."','".$ano_atual."-".$mes_atual."-01')");
            $result = $command->execute();
        }
               
    }

    public function getNumConcluido($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where situacao = 'REALIZADO'and assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }
        if($total == 0){
            return 0;
        }else{
            return ceil((($totalRealizado*100)/$total));
        }
    }

    public function getNumPlan($id){

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        return $total;
    }

    public function getNumResult($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where situacao = 'REALIZADO'and assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }

        return $totalRealizado;
    }

    public function getNumOK($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where judge = 'O.K.'and assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalOK = $perk['COUNT(id)'];
            break;
        }

        return $totalOK;
    }

    public function getNumNG($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where judge = 'N.G.'and assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalNG = $perk['COUNT(id)'];
            break;
        }

        return $totalNG;
    }

    public function getNumNGPorcentagem($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $total = $perk['COUNT(id)'];
            break;
        }

        $command = $connection->createCommand("SELECT COUNT(id) from item_assurance where judge = 'N.G.' and assurance = " . $id);

        $result = $command->queryAll();
        foreach ($result as $perk) {
            $totalRealizado = $perk['COUNT(id)'];
            break;
        }
        if($total == 0){
            return 0;
        }else{
           return ceil((($totalRealizado*100)/$total));
        }
    }

    public function actionGetreports($id){
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("SELECT nome from subitem_assurance_report where subitem_assurance = " . $id);

        $result = $command->queryAll();
        $html = '';
        foreach ($result as $perk) {
            $html .= '<a href=' .  Url::to("/ReportsFiles/" ) . $perk['nome'] .' target="_blank">
                    <img style="height: 25px;width: 50px;" src= "'. Yii::$app->request->baseUrl . '/img/pdf-icon.svg'. '"> 
                </a>';
        }
        return $html;
    }

}
