<?php

namespace frontend\controllers;

use Yii;
use common\models\Qhiboard;
use common\models\QhiboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QhiboardController implements the CRUD actions for Qhiboard model.
 */
class QhiboardController extends Controller
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
     * Lists all Qhiboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new QhiboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
  
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Qhiboard model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Qhiboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Qhiboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Qhiboard model.
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
     * Deletes an existing Qhiboard model.
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

    public function actionWeek()
    {
      $connection = Yii::$app->getDb();
        function semana_do_ano($dia,$mes,$ano){

        $var=intval( date('z', mktime(0,0,0,$mes,$dia,$ano) ) / 7 ) + 1;

        return $var;
        }

          function impr1($lp, $ap){
            
            if ($lp == 0){
              if ($ap == 0){
                $var = 100;
              }else{
                $var = -100;
              }
            }else{
              $var = round(($lp-$ap)/$lp*100);
            }
            if ($var >= 0){
                $var = 'class="impr" style="color: green; vertical-align:middle"><b>'.$var.'% ↓';
            }else if ($var >= -10){
                $var = $var*(-1);
                $var = 'class="impr" style="color: red; vertical-align:middle"><b>'.$var.'% ↑';
            }else{
                $var = $var*(-1);
                $var = 'class="impr" style="color: red; vertical-align:middle"><b>'.$var.'% ↑';
            }
            return $var;
          }
          
        

          function impr2($lp, $ap){
            if ($lp == 0){
              if ($ap == 0){
                $var = -100;
              }else{
                $var = 100;
              }
            }else{
              $var = round(($lp-$ap)/$lp*100);
            }
            if ($var >= 10){
                $var = 'class="impr" style="color: red; vertical-align:middle"><b>'.$var.'% ↓';
            }else if ($var >= 0){
                $var = $var;
                $var = 'class="impr" style="color: red; vertical-align:middle"><b>'.$var.'% ↓';
            }else{
                $var = $var*(-1);
                $var = 'class="impr" style="color: green; vertical-align:middle"><b>'.$var.'% ↑';
            }
            return $var;
          }

          function i1($lp, $ap){
            
            if ($lp == 0){
              if ($ap == 0){
                $var = 0;
              }else{
                $var = -100;
              }
            }else{
              $var = round(($lp-$ap)/$lp*100);
            }
            return $var;
          }

          function pts($lp, $y,$cond1,$cond2,$cond3){
            if ($lp >= $cond1){
              if ($y >= 24) {
                return 5;
              }elseif ($y >= 16) {
                return 4;
              }elseif ($y >= 8) {
                return 3;
              }elseif ($y >= 0) {
                return 2;
              }else{
                return 1;
              }
            }elseif ($lp >= $cond2){
              if ($y >= 18) {
                return 5;
              }elseif ($y >= 12) {
                return 4;
              }elseif ($y >= 6) {
                return 3;
              }elseif ($y >= 0) {
                return 2;
              }else{
                return 1;
              }
            }elseif ($lp >= $cond3) {
              if ($y >= 9) {
                return 5;
              }elseif ($y >= 5) {
                return 4;
              }elseif ($y >= 3) {
                return 3;
              }elseif ($y >= 0) {
                return 2;
              }else{
                return 1;
              }
            }elseif ($lp == 0 && $y == 0) {
              return 5;
            }
            else{
              if ($y >= 5) {
                return 5;
              }elseif ($y >= 0) {
                return 4;
              }else{
                return 1;
              }
            }
          }

        $week = semana_do_ano(date('d'),date('m'),date('Y'));
        $month = date('m');
        $M = strtoupper(date('M'));
        $year = date('Y');
        $Y = date('y');
        $ly = $Y-1;
        $LY = $year - 1;




              


                    $start_date = "01-".$month."-".$year;
                    $start_time = strtotime($start_date);

                    $end_time = strtotime("+1 month", $start_time);

                    for($i=$start_time; $i<$end_time; $i+=86400)
                    {
                       $list[] = date('Y-m-d-D', $i);
                    }

                    $week_total = array();
                    foreach ($list as $data) {
                        //print_r(substr($data,-3));
                      //echo $data; // 2018-12-01-Sat
                        if(!(substr($data,-3) == 'Sun' || substr($data,-3) == 'Sat')){
                            //$htm = $htm . '<th>'. substr($data, -6,-4) .'</th>';
                            $n = semana_do_ano(substr($data, -6,-4),substr($data, -9, -7),substr($data, 0, 4));
                            $lastday = substr($data,-6,-4);
                            if ($n < 10){
                              $n = '0'.$n.'';
                            }
                            array_push($week_total,$n);
                        }
                        
                    }
                    $key = array_search(53, $week_total);
                      if($key!==false){
                          unset($week_total[$key]);
                      }
                      
                      $week_total = array_unique($week_total);
                      

        $FFR1 = array(); $FFR2 = array(); $FFR3 = array();
        $FCR1 = array(); $FCR2 = array(); $FCR3 = array();
        $PRR1 = array(); $PRR2 = array(); $PRR3 = array();
        $TLDR1 = array(); $TLDR2 = array(); $TLDR3 = array();
        $IFRR1 = array(); $IFRR2 = array(); $IFRR3 = array();
        $LINE = array();
        $LRR1 = array(); $LRR2 = array(); $LRR3 = array();
        $NGL1 = array(); $NGL2 = array(); $NGL3 = array();
        $TEMP1 = array(); $TEMP2 = array(); $TEMP3 = array();
        $IFC = array();
        $CEO = array(); $SIQC = array();  $REW = array();

        $command = $connection->createCommand("SELECT COUNT(*) FROM lg.qhi_issues_w WHERE week = ".$week." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
        $result = $command->queryAll();
        foreach ($result as $perk) {
          $qtd = $perk['COUNT(*)'];
          break;
        }

        $insert1 = 0;
        $insert2 = 0;
        $insert3 = 0;
        if ($qtd == 0){
          $command = $connection->createCommand("INSERT INTO lg.qhi_issues_w (ceorep,rewf,salesiqc,week,month,year) VALUES (:ceoreport,:rewf,:salesiqc,:week,:month,:year)");
          $command->bindValue(':ceoreport', $insert1);
          $command->bindValue(':rewf', $insert2);
          $command->bindValue(':salesiqc', $insert3);
          $command->bindValue(':week', $week);
          $command->bindValue(':month', $month);
          $command->bindValue(':year', $year);
          $sql_result = $command->execute();
        }
        foreach ($week_total as $key) {


          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM lg.ffr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $accsvc = $perk['accsvc'];
                $waccs = $perk['waccs'];
                $rate = $perk['rate'];
                array_push($FFR1,$accsvc);
                array_push($FFR2,$waccs);
                array_push($FFR3,$rate);
                break;
              }

              $command = $connection->createCommand("SELECT fail, sales, rate FROM lg.fcr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $fc = $perk['fail'];
                $sales = $perk['sales'];
                $rate = $perk['rate'];
                array_push($FCR1,$fc);
                array_push($FCR2,$sales);
                array_push($FCR3,$rate);
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.prr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ppq = $perk['defect'];
                $tpq = $perk['tpq'];
                $ppm = $perk['ppm'];
                array_push($PRR1,$ppq);
                array_push($PRR2,$tpq);
                array_push($PRR3,$ppm);
                break;
              }

              $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.tldr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $def = $perk['defect'];
                $tpq = $perk['tpq'];
                $ppm = $perk['ppm'];
                array_push($TLDR1,$def);
                array_push($TLDR2,$tpq);
                array_push($TLDR3,$ppm);
                break;
              }

              $command = $connection->createCommand("SELECT rework, tpq, rate FROM lg.ifrr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $rew = $perk['rework'];
                $tpq = $perk['tpq'];
                $ppm = $perk['rate'];
                array_push($IFRR1,$rew);
                array_push($IFRR2,$tpq);
                array_push($IFRR3,$ppm);
                break;
              }

              $command = $connection->createCommand("SELECT qty FROM lg.linestop_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $qty = $perk['qty'];
                array_push($LINE,$qty);
                break;
              }

              $command = $connection->createCommand("SELECT ng, tpq, rate FROM lg.lrr_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ng = $perk['ng'];
                $tpq = $perk['tpq'];
                $rate = $perk['rate'];
                array_push($LRR1,$ng);
                array_push($LRR2,$tpq);
                array_push($LRR3,$rate);
                break;
              }

              $command = $connection->createCommand("SELECT ng, total, ppm FROM lg.nglot_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ng = $perk['ng'];
                $total = $perk['total'];
                $ppm = $perk['ppm'];
                array_push($NGL1,$ng);
                array_push($NGL2,$total);
                array_push($NGL3,$ppm);
                break;
              }

              $command = $connection->createCommand("SELECT temp, total, rate FROM lg.temp_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $temp = $perk['temp'];
                $total = $perk['total'];
                $rate = $perk['rate'];
                array_push($TEMP1,$temp);
                array_push($TEMP2,$total);
                array_push($TEMP3,$rate);
                break;
              }

              $command = $connection->createCommand("SELECT ifc FROM lg.ifcost_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ifc = $perk['ifc'];
                array_push($IFC,$ifc);
                break;
              }

              $command = $connection->createCommand("SELECT * FROM lg.qhi_issues_w WHERE week = ".$key ." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $salesiqc = $perk['salesiqc'];
                $ceorep = $perk['ceorep'];
                $rewf = $perk['rewf'];
                array_push($CEO,$ceorep);
                array_push($SIQC,$salesiqc);
                array_push($REW,$rewf);
                break;
              }
        }

          $command = $connection->createCommand("SELECT * FROM lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $accsvc = $perk['accsvc'];
                $waccs = $perk['waccs'];
                $rateFFR = $perk['rate'];
                break;
              }       
        
          $command = $connection->createCommand("SELECT fail, sales, rate FROM lg.fcr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $fc = $perk['fail'];
                $sales = $perk['sales'];
                $rateFCR = $perk['rate'];
                break;
              }
              
          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.prr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ppq = $perk['defect'];
                $tpqPRR= $perk['tpq'];
                $ppmPRR = $perk['ppm'];
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.tldr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $def = $perk['defect'];
                $tpqTLDR = $perk['tpq'];
                $ppmTLDR = $perk['ppm'];
                break;
              }
          $command = $connection->createCommand("SELECT rework, tpq, rate FROM lg.ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $rew = $perk['rework'];
                $tpqIFRR = $perk['tpq'];
                $ppmIFRR = $perk['rate'];
                break;
              }

          $command = $connection->createCommand("SELECT qty FROM lg.linestop_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $qty = $perk['qty'];
                break;
              }

              $command = $connection->createCommand("SELECT ng, tpq, rate FROM lg.lrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ngLRR = $perk['ng'];
                $tpqLRR = $perk['tpq'];
                $rateLRR = $perk['rate'];
                break;
              }

              $command = $connection->createCommand("SELECT ng, total, ppm FROM lg.nglot_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ngLot = $perk['ng'];
                $total = $perk['total'];
                $ppmLot = $perk['ppm'];
                break;
              }

              $command = $connection->createCommand("SELECT temp, total, rate FROM lg.temp_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $temp = $perk['temp'];
                $totaltemp = $perk['total'];
                $ratetemp = $perk['rate'];
                break;
              }

              $command = $connection->createCommand("SELECT ifc FROM lg.ifcost_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $ifc = $perk['ifc'];
                break;
              }

              $command = $connection->createCommand("SELECT * FROM lg.qhi_issues_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");

              $result = $command->queryAll();
              foreach ($result as $perk) {
                $salesiqc = $perk['salesiqc'];
                $ceorep = $perk['ceorep'];
                $rewf = $perk['rewf'];
                break;
              }

        $command = $connection->createCommand("SELECT COUNT(*) FROM lg.temp_w WHERE week = ".$week." AND month = ".$month." AND year = ".$year." ORDER BY id DESC");
        $result = $command->queryAll();
        foreach ($result as $perk) {
          $qtd = $perk['COUNT(*)'];
          break;
        }

        if (sizeof($TEMP2) == 0){
          $insert2 = 0;
        }else{
          $insert2 = $TEMP2[sizeof($TEMP2)-1];
        }

        $insert1 = 0;
        $insert3 = 0;
        if ($qtd == 0){
          $command = $connection->createCommand("INSERT INTO lg.temp_w (temp,total,rate,week,month,year) VALUES (:temp,:total,:rate,:week,:month,:year)");
          $command->bindValue(':temp', $insert1);
          $command->bindValue(':total', $insert2);
          $command->bindValue(':rate', $insert3);
          $command->bindValue(':week', $week);
          $command->bindValue(':month', $month);
          $command->bindValue(':year', $year);
          $sql_result = $command->execute();
          array_push($TEMP1,$insert1);
          array_push($TEMP2,$insert2);
          array_push($TEMP3,$insert3);
        }

        $htm = "

        <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
     <script type = \"text/javascript\">
        $(document).ready(function(){
        window.location.href='#weekly-table';
          var wtable = $('#weekly-table');
          wtable.find('tbody tr td').each(function(){
            if(!isNaN($(this).text())){
                var num = $(this).text();
                var numero = num.split('.');
                if (numero.length > 1){
                  numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
                  var num = numero.join(',');
                }else{
                  var num = num.split('').reverse().join('').split(/(\d{3})/).filter(Boolean)
    .join('.').split('').reverse().join('');
                 }

                $(this).text(num);
  
          }
          });

          
          wtable.find('tbody tr').each(function(){
            var td = $(this).find('td');
                var i = 0;

                while (i < td.length){
                  var str = td[i].innerHTML;
                  if(td[i].className == 'lp' || td[i].className == 'ap' || td[i].className == 'ao'){
                      td[i].innerHTML = \"<b>\"+str;
                  }
                  i++;
                }
          });
       
      });
     </script>";
          
        $colspan = sizeof($week_total)+2;
        $Acc = 0;
        $htm = '<table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-condensed table-hover">
                      <thead>
                <tr style="text-align: center; font-size:110%;">
                 <th style="vertical-align: middle; text-align: center;" rowspan=2>Division</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan=2>Domain</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan=2 colspan=2>Index</th>
                 ';
                      $htm = $htm.'<th style="vertical-align: middle; text-align: center;" rowspan="2" >' . $M .'';

                      $htm = $htm.'\''. $ly .' <br> Result</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan="2" >'.$M.'\''.$Y.' <br> Target</th>
                 <th style="vertical-align: middle; text-align: center;" colspan="'.$colspan.'" >'.$M.'\''.$Y.' Result</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan="2" >Target</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan="2" >Result</th>
                 <th style="vertical-align: middle; text-align: center;" rowspan="2" >Achievement</th>
                </tr>
                ';

                $htm = $htm.'<tr>';

                foreach ($week_total as $key) {
                  $htm = $htm.'<td style="vertical-align: middle; text-align: center;"width="80px"> <b>W'.$key.'</td>';
                }

                $htm = $htm.'

                 <td style="vertical-align: middle; text-align: center;"width="80px"> <b>Acc. </td>
                 <td style="vertical-align: middle; text-align: center;"width="80px"> <b>YOY</td>
                </tr>
                </thead>';

                $htm = $htm.'
                <tbody>
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="20" style="vertical-align: middle">Process Index</td>
                 <td rowspan="6" style="vertical-align: middle" >IQC</td>
                 <td bgColor="#e0e0e0" rowspan="3" style="vertical-align: middle" >PRR</td>
                 <td>Defect Qty</td>
                <td class="lp"><b>'.$ppq.'</td>

                <td class="ao"><b></td>';

                $restam = sizeof($week_total);
                $soma = 0;
                foreach ($PRR1 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $restam--;
                    $soma += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }

                $insert1 = $soma;
                $yoy = impr1($ppq,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td>Production Qty</td>
                <td class="lp">';

                $htm = $htm.'<b>'.$tpqPRR.'</td>
                <td class="ao"><b></td>';
                $soma1 = 0;
                foreach ($PRR2 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                  $soma1 += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }

                $insert2 = $soma1;
                $yoy = impr2($tpqPRR,$soma1);
                $htm = $htm.'<td class="ap"><b>'.$soma1.'</td>
                <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td bgColor="#e0e0e0" >PPM</td>
                <td bgColor="#e0e0e0" class="lp"><b>'.$ppmPRR.'</td>
                <td bgColor="#e0e0e0" class="ao"><b>454</td>';


                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*1000000);
                }

                $insert3 = $soma;
                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.prr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.prr_acc SET defect=".$insert1.",tpq=".$insert2.",ppm=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("INSERT INTO lg.prr_acc (defect,tpq,ppm,month,year) VALUES (:defect,:tpq,:ppm,:month,:year)");
                  $command->bindValue(':defect', $insert1);
                  $command->bindValue(':tpq', $insert2);
                  $command->bindValue(':ppm', $insert3);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute();
                }
                

                 
                foreach ($PRR3 as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                $yoy = impr1($ppmPRR,$soma);
                $y = i1($ppmPRR,$soma);
                $ptsPRR = pts($ppmPRR, $y, 5000, 3000, 1000);
                $ptsPRR = ($ptsPRR/5)*15;
                $p = ($ptsPRR/15)*100;


                $htm = $htm.'<td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                <td '.$yoy.'</td>
                <td class="patt">15</td>
                <td class="pts" >'.$ptsPRR.'</td>
                <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                 <td bgColor="#e0e0e0" rowspan="3" style="vertical-align: middle">LRR</td>
                 <td>Lot NG</td>
                <td class="lp"><b>'.$ngLRR.'</td>

                <td class="ao"><b></td>';

                $restam = sizeof($week_total);
                $soma = 0;
                foreach ($LRR1 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $restam--;
                    $soma += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }

                $insert1 = $soma;
                $yoy = impr1($tpqLRR,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td>Lot Received</td>
                <td class="lp">';

                $htm = $htm.'<b>'.$tpqLRR.'</td>
                <td class="ao"><b></td>';
                $soma1 = 0;
                foreach ($LRR2 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                  $soma1 += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }

                $insert2 = $soma1;
                $yoy = impr2($tpqPRR,$soma1);
                $htm = $htm.'<td class="ap"><b>'.$soma1.'</td>
                <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td bgColor="#e0e0e0" >Rate</td>
                <td bgColor="#e0e0e0" class="lp"><b>'.$rateLRR.'</td>
                <td bgColor="#e0e0e0" class="ao"><b>454</td>';


                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*100,2);
                }

                $insert3 = $soma;
                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.lrr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.lrr_acc SET ng=".$insert1.",tpq=".$insert2.",rate=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("INSERT INTO lg.lrr_acc (ng,tpq,rate,month,year) VALUES (:ng,:tpq,:rate,:month,:year)");
                  $command->bindValue(':ng', $insert1);
                  $command->bindValue(':tpq', $insert2);
                  $command->bindValue(':rate', $insert3);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute();
                }
                

                 
                foreach ($LRR3 as $key) {
                   $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                $yoy = impr1($rateLRR,$soma);
                $y = i1($rateLRR,$soma);
                $ptsLRR = pts($rateLRR, $y, 5000, 3000, 1000);
                $ptsLRR = ($ptsLRR/5)*15;
                $p = ($ptsLRR/15)*100;


                $htm = $htm.'<td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                <td '.$yoy.'</td>
                <td class="patt">15</td>
                <td class="pts" >'.$ptsLRR.'</td>
                <td class="prctg">'.$p.'%</td>
                </tr>';

        // AQUI COMEÇA O TLDR
                $htm = $htm.'
                <tr style="text-align: center; vertical-align: middle; font-size:110%;">
                <td style="vertical-align: middle;" rowspan="7">LQC</td>';

                $htm = $htm.'
                <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Total Line Defect Rate">TLDR</td>
                <td>Defect Qty</td>
                <td class="lp"><b>'.$def.'</td>
                <td class="ao"><b></td>';
                $soma = 0;
                $restam = sizeof($week_total);
                foreach ($TLDR1 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                  $restam--;
                  $soma += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                }

                $insert1 = $soma;
                $yoy = impr1($def,$soma);
                $htm = $htm.'<td class="ap"><b>'.$soma.'</td>
                <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td>Production Qty</td>
                <td class="lp"><b>'.$tpqTLDR.'</td>
                <td class="ao"><b></td>';
                $soma1 = 0;

                foreach ($TLDR2 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                  $soma1 += $key;
                }
                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td class="week"></td>';
                }
                $yoy = impr2($tpqTLDR,$soma1);

                $insert2 = $soma1;
                $htm = $htm.'<td class="ap"><b>'.$soma1.'</td>
                <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td bgColor="#e0e0e0" >PPM</td>
                <td bgColor="#e0e0e0" class="lp"><b>'.$ppmTLDR.'</td>
                <td bgColor="#e0e0e0" class="ao"><b>4200</td>';
                 
                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*1000000);
                }

                foreach ($TLDR3 as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }

                $insert3 = $soma;

                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.tldr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.tldr_acc SET defect=".$insert1.",tpq=".$insert2.",ppm= ".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("INSERT INTO lg.tldr_acc (defect,tpq,ppm,month,year) VALUES (:defect,:tpq,:ppm,:month,:year)");
                  $command->bindValue(':defect', $insert1);
                  $command->bindValue(':tpq', $insert2);
                  $command->bindValue(':ppm', $insert3);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute(); 
                }

                $yoy = impr1($ppmTLDR,$soma);
                $y = i1($ppmTLDR,$soma);
                $ptsTLDR = pts($ppmTLDR, $y, 10000, 5000, 2000);
                $ptsTLDR = ($ptsTLDR/5)*10;
                $p = ($ptsTLDR/10)*100;
                $htm = $htm.'<td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                <td '.$yoy.'</td>
                <td class="patt">10</td>
                <td class="pts" >'.$ptsTLDR.'</td>
                <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%">
                <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Intern Failure Rework Rate" >IFRR </td>
                <td>Rework Qty</td>
                 <td class="lp"><b>'.$rew.'</td>
                 <td class="ao"><b></td>';
                $soma = 0;
                $restam = sizeof($week_total);
                foreach ($IFRR1 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                  $restam--;
                  $soma+=$key;
                }

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td class="week"></td>';
                }

                $insert1 = $soma;

                 
                $yoy = impr1($rew,$soma);
                $htm = $htm.'
                     <td class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                  <td>Production Qty</td>
                 <td class="lp"><b>'.$tpqIFRR.'</td>
                 <td class="ao"><b></td>';
                 $soma1 = 0;
                 foreach ($IFRR2 as $key) {
                    $htm = $htm.'<td class="week">'.$key.'</td>';
                    $soma1+=$key;
                 }

                 for ($i=0; $i < $restam; $i++) { 
                    $htm = $htm.'<td class="week"></td>';
                 }

                $yoy = impr2($tpqIFRR,$soma1);

                $insert2 = $soma1;
                $htm = $htm.'
                     <td class="ap"><b>'.$soma1.'</td>
                     <td '.$yoy.'</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                  <td bgColor="#e0e0e0">PPM</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$ppmIFRR.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>2,45</td>';
                 
                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*100,2);
                }

                $insert3 = $soma;

                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.ifrr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.ifrr_acc SET rework=".$insert1.",tpq=".$insert2.",rate=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("INSERT INTO lg.ifrr_acc (rework,tpq,rate,month,year) VALUES (:rework,:tpq,:rate,:month,:year)");
                  $command->bindValue(':rework', $insert1);
                  $command->bindValue(':tpq', $insert2);
                  $command->bindValue(':rate', $insert3);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute();
                }
                  

                foreach ($IFRR3 as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                 
                $yoy = impr1($ppmIFRR,$soma);
                $y = i1($ppmIFRR,$soma);
                $ptsIFRR = pts($ppmIFRR, $y, 5, 3, 1);
                $ptsIFRR = ($ptsIFRR/5)*10;
                $p = ($ptsIFRR/10)*100;
                $htm = $htm.'
                     <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                  <td class="patt">10</td>
                 <td class="pts" >'.$ptsIFRR.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                  <td bgcolor="#e0e0e0" >Line Stop Qty</td>
                  <td bgColor="#e0e0e0">Qty Line Stop QA</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$qty.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>0</td>';
                $soma = 0;
                $restam = sizeof($week_total);
                foreach ($LINE as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                  $soma += $key;
                  $restam--;
                }

                $insert1 = $soma;

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }

                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.linestop_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.linestop_acc SET qty=".$insert1." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("INSERT INTO lg.linestop_acc (qty,month,year) VALUES (:qty,:month,:year)");
                  $command->bindValue(':qty', $insert1);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute();
                }
                 
                $yoy = impr1($qty,$soma);
                $y = i1($qty,$soma);
                if ($y > 0){
                  $ptsLS = 5;
                }else{
                  $ptsLS = 1;
                }
                $p = ($ptsLS/5)*100;
                $htm = $htm.'
                     <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                <td class="patt">5</td>
                <td class="pts" >'.$ptsLS.'</td>
                <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'

                <tr style="text-align: center; font-size:110%";>
                <td style="vertical-align: middle;" rowspan="3">OQC</td>
                <td bgcolor="#e0e0e0" style="vertical-align: middle;" rowspan="3">NGC Sample Rate</td>
                ';


                $htm = $htm.'
                <td style="vertical-align: middle;" >NG Lot</td>
                <td class="lp"><b>'.$ngLot.'</td>
                <td class="ao"><b></td>';

              $restam = sizeof($week_total);
              $soma = 0;
              foreach ($NGL1 as $key) {
                $htm = $htm.'<td class="week">'.$key."</td>";
                $restam--;
                $soma += $key;
              }
              $insert1 = $soma;
              $yoy = impr1($ngLot,$soma);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $htm = $htm.'
                 <td class="ap"><b>'.$soma.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Total Lot Inspection</td>
                 <td class="lp"><b>'.$total.'</td>
                 <td class="ao"><b></td>';
                 $soma1 = 0;
              foreach ($NGL2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $soma1 += $key;
              }
              $insert2 = $soma1;
              
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $yoy = impr2($total,$soma1);
                 $htm = $htm.'
                 <td class="ap"><b>'.$soma1.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td bgcolor="#e0e0e0" >PPM </td>
                 <td bgcolor="#e0e0e0" class="lp"><b>'.$ppmLot.'</td>
                 <td bgcolor="#e0e0e0" class="ao"><b>1000</td>';
              foreach ($NGL3 as $key) {
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week">'.$key.'</td>';
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week"></td>';
              }
              if($soma1 != 0){
                $soma = round($soma/$soma1*1000000);
              }
              $insert3 = $soma;

              $command = $connection->createCommand("SELECT COUNT(*) FROM lg.nglot_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.nglot_acc SET ng=".$insert1.",total=".$insert2.",ppm=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                $command = $connection->createCommand("INSERT INTO lg.nglot_acc (ng,total,ppm,month,year) VALUES (:ng,:total,:ppm,:month,:year)");
                $command->bindValue(':ng', $insert1);
                $command->bindValue(':total', $insert2);
                $command->bindValue(':ppm', $insert3);
                $command->bindValue(':month', $month);
                $command->bindValue(':year', $year);
                $sql_result = $command->execute();
              }
              $yoy = impr1($ppmLot,$soma);
              $y = i1($ppmLot,$soma);
              $ptsOGC = pts($ppmLot, $y, 10000, 5000, 2000);
              
              $ptsOGC = ($ptsOGC/5)*10;

                $p = ($ptsOGC/10)*100;
                $htm = $htm.'
                 <td bgcolor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                 <td '.$yoy.'</td>
                 <td class="patt">10</td>
                 <td class="pts" >'.$ptsOGC.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                  <td rowspan="4" style="vertical-align: middle;>Common</td>
                  <td rowspan="3" style="vertical-align: middle;"title="Failure Cost Rate">Common </td>
                  
                  ';

                $htm = $htm.'
                  <td bgcolor="#e0e0e0" rowspan="3" style="vertical-align: middle;" title="Temporary Workers Rate">OS</td>
                  <td style="vertical-align: middle;">Temporary Qty</td>
                  <td class="lp"><b>'.$temp.'</td>
                  <td class="ao"><b></td>';

              $restam = sizeof($week_total);
              $Acc = 0;
              foreach ($TEMP1 as $key) {
                $htm = $htm.'<td class="week">'.$key."</td>";
                $restam--;
                $Acc = $key;
              }
              $insert1 = $Acc;
              $yoy = impr1($temp,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Total QA</td>
                 <td class="lp"><b>'.$totaltemp.'</td>
                 <td class="ao"><b></td>';
                 $Acc = 0;
              foreach ($TEMP2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $Acc = $key;
              }
              $insert2 = $Acc;
              
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $yoy = impr2($total,$Acc);
                 $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td bgColor="#e0e0e0" >Rate </td>
                 <td bgColor="#e0e0e0" class="lp"><b>'.$ratetemp.'</td>
                 <td bgColor="#e0e0e0" class="ao"><b></td>';
              foreach ($TEMP3 as $key) {
                $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
              }
              if($insert2 != 0){
                $Acc = round($insert1/$insert2*100,2);
              }
              $insert3 = $Acc;

              $command = $connection->createCommand("SELECT COUNT(*) FROM lg.temp_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.temp_acc SET temp=".$insert1.",total=".$insert2.",rate=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                $command = $connection->createCommand("INSERT INTO lg.temp_acc (temp,total,rate,month,year) VALUES (:temp,:total,:rate,:month,:year)");
                $command->bindValue(':temp', $insert1);
                $command->bindValue(':total', $insert2);
                $command->bindValue(':rate', $insert3);
                $command->bindValue(':month', $month);
                $command->bindValue(':year', $year);
                $sql_result = $command->execute();
              }
              $yoy = impr1($ratetemp,$Acc);
              $y = i1($ratetemp,$Acc);
              
              $ptstemp = 5;

                $p = ($ptstemp/5)*100;
                $htm = $htm.'
                 <td bgColor="#e0e0e0" class="ap"><b>'.$Acc.'</td>
                 <td '.$yoy.'</td>
                 <td class="patt">5</td>
                 <td class="pts" >'.$ptstemp.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                  <td bgcolor="#e0e0e0" style="vertical-align: middle;"title="Failure Cost Rate">IF Cost </td>
                  <td bgColor="#e0e0e0" >IF Cost ($)</td>
                 <td bgColor="#e0e0e0" class="lp"><b>'.$ifc.'</td>
                 <td bgColor="#e0e0e0" class="ao"><b>2270</td>';
                 $soma = 0;
                 $restam = sizeof($week_total);
              foreach ($IFC as $key) {
                $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                $restam--;
                $soma += $key;
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
              }
              $insert3 = $soma;

              $command = $connection->createCommand("SELECT COUNT(*) FROM lg.ifcost_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.ifcost_acc SET ifc=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                $command = $connection->createCommand("INSERT INTO lg.ifcost_acc (ifc,month,year) VALUES (:ifc,:month,:year)");
                $command->bindValue(':ifc', $insert3);
                $command->bindValue(':month', $month);
                $command->bindValue(':year', $year);
                $sql_result = $command->execute();
              }
              $yoy = impr1($ifc,$soma);
              $y = i1($ifc,$soma);
              
              if ($y >= 2) $ptsFCR = 5;
              elseif ($y >= 1) $ptsFCR = 4;
              elseif ($y >= 0) $ptsFCR = 3;
              elseif ($y >= -1) $ptsFCR =  2;
              else $ptsFCR =  1;
              $ptsFCR = ($ptsFCR/5)*15;

                $p = ($ptsFCR/15)*100;
                $htm = $htm.'
                 <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                 <td '.$yoy.'</td>
                 <td class="patt">15</td>
                 <td class="pts" >'.$ptsFCR.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                <td rowspan="6" style="vertical-align: middle">Target Index</td>';
                
                

                $htm = $htm.'
                 <td rowspan="3" style="vertical-align: middle">Market</td>
                 <td bgcolor="#e0e0e0" rowspan="3" style="vertical-align: middle" title="Failure Field Rate">FFR </td>
                 <td>Acc. SVC</td>
                 <td class="lp">';

              $htm = $htm.'<b>'.$accsvc.'</td>
                 <td class="ao"><b></td>';
              $restam = sizeof($week_total);
              $Acc = 0;
              foreach ($FFR1 as $key){
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $Acc = $key;
                $restam--;
              }

              $yoy = impr1($accsvc,$Acc);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              
              $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;" class="FFR">
                 <td>W. Acc. Sales</td>
                 <td class="lp"><b>'.$waccs.'</td>
                 <td class="ao"><b></td>';

              $insert1 = $Acc;

              foreach ($FFR2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $Acc=$key;
              }
              $yoy = impr2($waccs,$Acc);
              $insert2 = $Acc;

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }


              $htm = $htm.'
                 <td class="ap"><b>'.$Acc.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td bgColor="#e0e0e0">Rate</td>
                 <td bgColor="#e0e0e0" class="lp"><b>'.$rateFFR.'</td>
                 <td bgColor="#e0e0e0" class="ao"><b>1,90</td>';
                 
              foreach ($FFR3 as $key) {
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week">'.$key.'</td>';
                $Acc=$key;
              }
              $yoy = impr1($rateFFR,$Acc);

              $insert3 = $Acc;
              $command = $connection->createCommand("SELECT COUNT(*) FROM lg.ffr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.ffr_acc SET accsvc=".$insert1.",waccs=".$insert2.",rate=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                $command = $connection->createCommand("INSERT INTO lg.ffr_acc (accsvc,waccs,rate,month,year) VALUES (:accsvc,:waccs,:rate,:month,:year)");
                $command->bindValue(':accsvc', $insert1);
                $command->bindValue(':waccs', $insert2);
                $command->bindValue(':rate', $insert3);
                $command->bindValue(':month', $month);
                $command->bindValue(':year', $year);
                $sql_result = $command->execute();
              }
                


              $y = i1($rateFFR,$Acc);
              $ptsFFR = pts($rateFFR, $y, 10, 5, 2);
              $ptsFFR = ($ptsFFR/5)*15;


              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week"></td>';
              }

              $p = ($ptsFFR/15)*100;
              $htm = $htm.'
                 <td bgColor="#e0e0e0" class="ap"><b>'.$Acc.'</td>
                 <td '.$yoy.'</td>
                 <td class="patt">15</td>
                 <td class="pts" >'.$ptsFFR.'</td>
                 <td class="prctg">'.$p.'%</td>
                </tr>';


              

              $htm = $htm.'
              <tr style="text-align: center; font-size:110%;">
              <td rowspan="3">Quality Issue</td>
                <td bgcolor="#e0e0e0" colspan="2">Rework Field</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$rewf.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>0</td>';
                $restam = sizeof($week_total);
                $soma = 0;
                foreach ($REW as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                  $soma += $key;
                  $restam--;
                }

                $insert1 = $soma;

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                 
                $yoy = impr1($rewf,$insert1);
                $y = i1($rewf,$insert1);
                $pts=0;
                $pts-=($soma);
                $htm = $htm.'
                     <td bgcolor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                <td class="patt">-</td>
                <td class="pts" >-</td>
                <td class="prctg">-</td>
                </tr>';

                $htm = $htm.'
              <tr style="text-align: center; font-size:110%;">
                <td bgcolor="#e0e0e0" colspan="2">CEO Report</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$ceorep.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>0</td>';
                 

               
                $soma = 0;
                foreach ($CEO as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                  $soma+=$key;
                }


                $insert2 = $soma;

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                 
                $yoy = impr1($ceorep,$soma);
                $y = i1($ceorep,$soma);
                $pts-=($soma);
                $htm = $htm.'
                     <td bgcolor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                <td class="patt">-</td>
                <td class="pts" >-</td>
                <td class="prctg">-</td>
                </tr>';

                $htm = $htm.'
              <tr style="text-align: center; font-size:110%;">
                <td bgcolor="#e0e0e0" colspan="2">Sales IQC</td>
                  <td bgColor="#e0e0e0"class="lp"><b>'.$salesiqc.'</td>
                  <td bgColor="#e0e0e0" class="ao"><b>0</td>';
                 
                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*100,2);
                }

                $insert3 = $soma;
                $command = $connection->createCommand("SELECT COUNT(*) FROM lg.qhi_issues_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd == 0){
                  $command = $connection->createCommand("INSERT INTO lg.qhi_issues_acc (ceorep,rewf,salesiqc,month,year) VALUES (:ceoreport,:rewf,:salesiqc,:month,:year)");
                  $command->bindValue(':ceoreport', $insert1);
                  $command->bindValue(':rewf', $insert2);
                  $command->bindValue(':salesiqc', $insert3);
                  $command->bindValue(':month', $month);
                  $command->bindValue(':year', $year);
                  $sql_result = $command->execute();
                }else{
                  $command = $connection->createCommand("UPDATE lg.qhi_issues_acc SET ceorep=".$insert1.",rewf=".$insert2.",salesiqc=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }
                  

                foreach ($SIQC as $key) {
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week">'.$key.'</td>';
                }

                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td bgColor="#e0e0e0" class="week"></td>';
                }
                 
                $yoy = impr1($insert3,$soma);
                $y = i1($insert3,$soma);
                $pts-=($soma);
                $htm = $htm.'
                     <td bgcolor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td '.$yoy.'</td>
                <td class="patt">-</td>
                <td class="pts" >-</td>
                <td class="prctg">-</td>
                </tr>';


                $colspan = $colspan+6;
                $somarates = $ptsFFR+$ptsFCR+$ptsPRR+$ptsTLDR+$ptsIFRR+$ptsLRR+$ptsLS+$ptsOGC+$ptstemp+$pts;
                
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                <td colspan = '.$colspan.'></td>
                <td >Total</td>
                <td class="pts">'.$somarates.'</td>
                <td class="prctg">'.$somarates.'%</td>
                </tr>
               </tbody>';
              
              $htm = $htm.'</table>';
              return $htm;
    }

    public function actionMonth()
    {
      function impr1($lp, $ap){

            if ($ap == ''){
                $var = 'class="impr" style="color: black; vertical-align:middle"><b>';
            }else{
                if ($lp == 0){
                  if ($ap == 0){
                    $var = 0;
                  }else{
                    $var = -100;
                  }
                }else{
                  $var = round(($lp-$ap)/$lp*100);
                }
                if ($var >= 0){
                    $var = 'class="impr" style="color:green; vertical-align:middle"><b>'.$var.'% ↓';
                }else if ($var >= -10){
                    $var = $var*(-1);
                    $var = 'class="impr" style="color:red; vertical-align:middle"><b>'.$var.'% ↑';
                }else{
                    $var = $var*(-1);
                    $var = 'class="impr" style="color:red; vertical-align:middle"><b>'.$var.'% ↑';
                }
            }
            
            return $var;
    }

    function acc1($lp, $ap){
        if ($ap == 0) {
            $var = '';
        }else{
            $acc = round($lp/$ap*100,2);
            $var = $acc;
        }
        return $var;
    }

    function acc2($lp, $ap){
        if ($ap == 0) {
            $var = '';
        }else{
            $acc = round($lp/$ap*1000000);
            $var = $acc;
        }
        return $var;
    }


        $year = date('Y');
        $Y = date('y');
        $ly = $Y-1;
        $LY = $year - 1;


        $connection = Yii::$app->getDb();

        $allmonths = [1,2,3,4,5,6,7,8,9,10,11,12];

        $PRRly = array(); $PRRLY1 = 0;  $PRRLY2 = 0;
        $PRRpy = array(); $PRRPY1 = 0;  $PRRPY2 = 0;
        $LRRly = array(); $LRRLY1 = 0;  $LRRLY2 = 0;
        $LRRpy = array(); $LRRPY1 = 0;  $LRRPY2 = 0;
        $TLDRly = array();  $TLDRLY1 = 0; $TLDRLY2 = 0;
        $TLDRpy = array();  $TLDRPY1 = 0; $TLDRPY2 = 0;
        $IFRRly = array();  $IFRRLY1 = 0; $IFRRLY2 = 0;
        $IFRRpy = array();  $IFRRPY1 = 0; $IFRRPY2 = 0;
        $LINEly = array();  $LINELY1 = 0;
        $LINEpy = array();  $LINEPY1 = 0;
        $OQCly = array(); $OQCLY1 = 0;  $OQCLY2 = 0;
        $OQCpy = array(); $OQCPY1 = 0;  $OQCPY2 = 0;
        $TEMPly = array(); $TEMPLY1 = 0;  $TEMPLY2 = 0;
        $TEMPpy = array(); $TEMPPY1 = 0;  $TEMPPY2 = 0;
        $IFCly = array(); $IFCLY1 = 0;
        $IFCpy = array(); $IFCPY1 = 0;
        $FFRly = array(); $FFRLY1 = 0;  $FFRLY2 = 0;
        $FFRpy = array(); $FFRPY1 = 0;  $FFRPY2 = 0;
        $FCRly = array(); $FCRLY1 = 0;  $FCRLY2 = 0;
        $FCRpy = array(); $FCRPY1 = 0;  $FCRPY2 = 0;
        $CeoReppy = array();  $ceorepPY1 = 0;
        $SalesIQCpy = array();  $siqcpy = 0;
        $REWFpy = array();  $rewfpy1 = 0;
        
        foreach ($allmonths as $month) {

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.prr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $PRRLY1 += $perk['defect'];
                $PRRLY2 += $perk['tpq'];
                array_push($PRRly, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.prr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $PRRPY1 += $perk['defect'];
                $PRRPY2 += $perk['tpq'];
                array_push($PRRpy, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT ng, tpq, rate FROM lg.lrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $LRRLY1 += $perk['ng'];
                $LRRLY2 += $perk['tpq'];
                array_push($LRRly, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT ng, tpq, rate FROM lg.lrr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $LRRPY1 += $perk['ng'];
                $LRRPY2 += $perk['tpq'];
                array_push($LRRpy, $perk['rate']);
                break;
              }


          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.tldr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TLDRLY1 += $perk['defect'];
                $TLDRLY2 += $perk['tpq'];
                array_push($TLDRly, $perk['ppm']);
                break;
              }
              
          $command = $connection->createCommand("SELECT defect, tpq, ppm FROM lg.tldr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TLDRPY1 += $perk['defect'];
                $TLDRPY2 += $perk['tpq'];
                array_push($TLDRpy, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT rework, tpq, rate FROM lg.ifrr_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFRRLY1 += $perk['rework'];
                $IFRRLY2 += $perk['tpq'];
                array_push($IFRRly, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT rework, tpq, rate FROM lg.ifrr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFRRPY1 += $perk['rework'];
                $IFRRPY2 += $perk['tpq'];
                array_push($IFRRpy, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT qty FROM lg.linestop_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $LINELY1 += $perk['qty'];
                array_push($LINEly, $perk['qty']);
                break;
              }

          $command = $connection->createCommand("SELECT qty FROM lg.linestop_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $LINEPY1 += $perk['qty'];
                array_push($LINEpy, $perk['qty']);
                break;
              }

          $command = $connection->createCommand("SELECT ng, total, ppm FROM lg.nglot_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $OQCLY1 += $perk['ng'];
                $OQCLY2 += $perk['total'];
                array_push($OQCly, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT ng, total, ppm FROM lg.nglot_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $OQCPY1 += $perk['ng'];
                $OQCPY2 += $perk['total'];
                array_push($OQCpy, $perk['ppm']);
                break;
              }

          $command = $connection->createCommand("SELECT temp,total,rate FROM lg.temp_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TEMPLY1 += $perk['temp'];
                $TEMPLY2 += $perk['total'];
                array_push($TEMPly, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT temp,total,rate FROM lg.temp_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $TEMPPY1 += $perk['temp'];
                $TEMPPY2 += $perk['total'];
                array_push($TEMPpy, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT ifc FROM lg.ifcost_acc WHERE month = ".$month." AND year = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFCLY1 += $perk['ifc'];
                array_push($IFCly, $perk['ifc']);
                break;
              }

          $command = $connection->createCommand("SELECT ifc FROM lg.ifcost_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $IFCPY1 += $perk['ifc'];
                array_push($IFCpy, $perk['ifc']);
                break;
              }

          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$LY." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FFRLY1 += $perk['accsvc'];
                $FFRLY2 += $perk['waccs'];
                array_push($FFRly, $perk['rate']);
                break;
              }

          $command = $connection->createCommand("SELECT accsvc, waccs, rate FROM lg.ffr_acc WHERE `month` = ".$month." AND `year` = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $FFRPY1 += $perk['accsvc'];
                $FFRPY2 += $perk['waccs'];
                array_push($FFRpy, $perk['rate']);
                break;
              }


          $command = $connection->createCommand("SELECT rewf,salesiqc,ceorep FROM lg.qhi_issues_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
              $result = $command->queryAll();
              foreach ($result as $perk) {
                $rewfpy1 += $perk['rewf'];
                array_push($REWFpy, $perk['rewf']);
                $siqcpy += $perk['salesiqc'];
                array_push($SalesIQCpy, $perk['salesiqc']);
                $ceorepPY1 += $perk['ceorep'];
                array_push($CeoReppy, $perk['ceorep']);
                break;
              }

        }
      $htm = "

<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js\"></script>
     <script type = \"text/javascript\">
        window.location.href='#monthly-table';
        var mtable = $('#monthly-table');
          mtable.find('tbody tr td').each(function(){
            if(!isNaN($(this).text())){
                var num = $(this).text();
                var numero = num.split('.');
                if (numero.length > 1){
                  numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');
                  var num = numero.join(',');
                }else{
                  var num = num.split('').reverse().join('').split(/(\d{3})/).filter(Boolean)
    .join('.').split('').reverse().join('');
                }

                $(this).text(num);
            }
          });

          
          mtable.find('tbody tr').each(function(){
            var td = $(this).find('td');
                var i = 0;

                while (i < td.length){
                  var str = td[i].innerHTML;
                  if(td[i].className == 'acc'){
                      td[i].innerHTML = \"<b>\"+str;
                  }
                  i++;
                }
          });
       
     </script>";

$htm = '<table href="#" id = "monthly-table" class="table table-striped table-condensed table-hover">
          <thead>
                <tr style="text-align: center; font-size:110%;">
                 <th style="vertical-align: middle; text-align: center;" >Division</th>
                 <th style="vertical-align: middle; text-align: center;" >Domain</th>
                 <th style="vertical-align: middle; text-align: center;" colspan=2>Index</th>
                 <th width="80px" style="text-align: center;">Jan</th>
                 <th width="80px" style="text-align: center;">Feb</th>
                 <th width="80px" style="text-align: center;">Mar</th>
                 <th width="80px" style="text-align: center;">Apr</th>
                 <th width="80px" style="text-align: center;">May</th>
                 <th width="80px" style="text-align: center;">Jun</th>
                 <th width="80px" style="text-align: center;">Jul</th>
                 <th width="80px" style="text-align: center;">Aug</th>
                 <th width="80px" style="text-align: center;">Sep</th>
                 <th width="80px" style="text-align: center;">Oct</th>
                 <th width="80px" style="text-align: center;">Nov</th>
                 <th width="80px" style="text-align: center;">Dec</th>
                 <th width="80px" style="text-align: center;">Acc.</th>
                </tr>
                ';

     $htm = $htm.'
     <tbody>
      <tr style="text-align: center;">
       <td rowspan="24" style="text-align: center; vertical-align: middle">Process Index</td>';

      $htm = $htm.'
       <td rowspan="6" style="text-align: center; vertical-align: middle">IQC</td>
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Parts Return Rate">PRR </td>
       <td>\''.$ly.'</td>';

       $restam = 12;
       foreach ($PRRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

        $accly = acc2($PRRLY1,$PRRLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';
        
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($PRRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc2($PRRPY1,$PRRPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

        
       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($PRRpy); $i++) {
        $yoy = impr1($PRRly[$i],$PRRpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($PRRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);

        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

          $htm = $htm.'
      </tr>';


      $htm = $htm.'
      <tr style="text-align: center;" >
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Lot Reject Rate">LRR </td>
       <td>\''.$ly.'</td>';

       $restam = 12;
       foreach ($LRRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

        $accly = acc1($LRRLY1,$LRRLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';
        
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($LRRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc1($LRRPY1,$LRRPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

        
       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($LRRpy); $i++) {
        $yoy = impr1($LRRly[$i],$LRRpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($LRRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);

        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

          $htm = $htm.'
      </tr>';


      $htm = $htm.'
      <tr style="text-align: center;">
      <td rowspan="9" style="text-align: center; vertical-align: middle">LQC</td>
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Total Line Defect Rate">TLDR </td>
       <td>\''.$ly.'</td>';


        $restam = 12;
        foreach ($TLDRly as $key) {

            $htm = $htm.'<td class="ly">'.$key.'</td>';
            $restam--;
        }

        for ($i=0; $i < $restam; $i++) { 
            $htm = $htm.'<td class="ly"><b></td>'; 
        }

        $accly = acc2($TLDRLY1,$TLDRLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($TLDRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc2($TLDRPY1,$TLDRPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($TLDRpy); $i++) {
        $yoy = impr1($TLDRly[$i],$TLDRpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($TLDRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);
        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';
       $htm = $htm.'
      </tr>';

      $htm = $htm.'
      <tr style="text-align: center;">
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Return Rate">IFRR </td>
       <td>\''.$ly.'</td>';


       $restam = 12;
       foreach ($IFRRly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

        $accly = acc1($IFRRLY1,$IFRRLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';

        
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($IFRRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc1($IFRRPY1,$IFRRPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($IFRRpy); $i++) {
        $yoy = impr1($IFRRly[$i],$IFRRpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($IFRRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);
        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

       $htm = $htm.'
      </tr>';

             $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Line Stop Number">Line Stop Qty</td>
       <td>\''.$ly.'</td>';


       $restam = 12;
       foreach ($LINEly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

        $htm = $htm.'<td class="acc"><b>'.$LINELY1.'</td>';

        
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($LINEpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $htm = $htm.'<td class="acc"><b>'.$LINEPY1.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($LINEpy); $i++) {
        $yoy = impr1($LINEly[$i],$LINEpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($LINEpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($LINELY1,$LINEPY1);
        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

       $htm = $htm.'
      </tr>';

      $htm = $htm.'
      <tr style="text-align: center;">
       <td rowspan="3" style="text-align: center; vertical-align: middle">OQC</td>
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="OQC Defect Rate">NGC Sample Rate</td>
       <td>\''.$ly.'</td>';


        $restam = 12;
        foreach ($OQCly as $key) {

            $htm = $htm.'<td class="ly">'.$key.'</td>';
            $restam--;
        }

        for ($i=0; $i < $restam; $i++) { 
            $htm = $htm.'<td class="ly"><b></td>'; 
        }

        $accly = acc2($OQCLY1,$OQCLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($OQCpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc2($OQCPY1,$OQCPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($OQCpy); $i++) {
        $yoy = impr1($OQCly[$i],$OQCpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($OQCpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);
        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';
       $htm = $htm.'
      </tr>';


      $htm = $htm.'
      <tr style="text-align: center;">
      <td rowspan="3" style="text-align: center; vertical-align: middle">Common</td>
      <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Temporary Workers Rate">OS</td>
       <td>\''.$ly.'</td>';


        $restam = 12;
        foreach ($TEMPly as $key) {

            $htm = $htm.'<td class="ly">'.$key.'</td>';
            $restam--;
        }

        for ($i=0; $i < $restam; $i++) { 
            $htm = $htm.'<td class="ly"><b></td>'; 
        }

        $accly = acc1($TEMPLY1,$TEMPLY2);
        $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($TEMPpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $accpy = acc2($TEMPPY1,$TEMPPY2);
        $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($TEMPpy); $i++) {
        $yoy = impr1($TEMPly[$i],$TEMPpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($TEMPpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);
        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';
       $htm = $htm.'
      </tr>';


      $htm = $htm.'
      <tr style="text-align: center;" >
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Cost">IF Cost</td>
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Intern Failure Cost">IF Cost ($)</td>
       <td>\''.$ly.'</td>';

       $restam = 12;
       foreach ($IFCly as $key) {

         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

        $htm = $htm.'<td class="acc"><b>'.$IFCLY1.'</td>';
        
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($IFCpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }

        $htm = $htm.'<td class="acc"><b>'.$IFCPY1.'</td>';

        
       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($IFCpy); $i++) {
        $yoy = impr1($IFCly[$i],$IFCpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($IFCpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }

        $acc = impr1($accly,$accpy);

        $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

          $htm = $htm.'
      </tr>';

       $htm = $htm.'
      <tr style="text-align: center;">
       <td rowspan="6" style="text-align: center; vertical-align: middle">Target Index</td>
       <td rowspan="3" style="text-align: center; vertical-align: middle">Market</td>
       <td bgColor="#e0e0e0" rowspan="3" style="text-align: center; vertical-align: middle" title="Failure Field Rate">FFR </td>
       <td>\''.$ly.'</td>';
       $restam = 12;
       foreach ($FFRly as $key) {
         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }

       $accly = acc1($FFRLY1,$FFRLY2);
       $htm = $htm.'<td class="acc"><b>'.$accly.'</td>';
       $htm = $htm.'
      </tr>
      <tr style="text-align: center;">
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($FFRpy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }
       $accpy = acc1($FFRPY1,$FFRPY2);
       $htm = $htm.'<td class="acc"><b>'.$accpy.'</td>';
       $htm = $htm.'
       </tr>
      <tr bgColor="#e0e0e0" style="text-align: center;">
       <td bgColor="#e0e0e0">YOY</td>';
      for ($i=0; $i < sizeof($FFRpy); $i++) {
        $yoy = impr1($FFRly[$i],$FFRpy[$i]);
        $htm = $htm.'<td bgColor="#e0e0e0" '.$yoy.'</td>';
      }

      $restam = 12-sizeof($FFRpy);
      for ($i=0; $i < $restam; $i++) {
        $htm = $htm.'<td bgColor="#e0e0e0" class="impr"></td>';
      }
      $acc = impr1($accly,$accpy);

      $htm = $htm.'<td class="acc" bgColor = "#e0e0e0" '.$acc.'</td>';

       $htm = $htm.'
      </tr>
      <tr style="text-align: center;" >
       <td rowspan="3" style="text-align: center; vertical-align: middle" title="Quality Issue">Quality Issue</td>
       <td bgColor="#e0e0e0" style="text-align: center; vertical-align: middle">Rework Field</td>
       <td>\''.$Y.'</td>
       ';

       $restam = 12;
       foreach ($REWFpy as $key) {
         $htm = $htm.'<td class="ly">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="ly"><b></td>'; 
       }
        $htm = $htm.'<td class="acc"><b>'.$rewfpy1.'</td>';

       $htm = $htm.'
      </tr>';

      $htm = $htm.'
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">CEO Report</td>
       <td>\''.$Y.'</td>';

       $restam = 12;
       foreach ($CeoReppy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }
        $htm = $htm.'<td class="acc"><b>'.$ceorepPY1.'</td>';

       $htm = $htm.'
       </tr>
      <tr style="text-align: center;">
       <td bgColor="#e0e0e0">Sales IQC</td>
       <td>\''.$Y.'</td>';
       $restam = 12;
       foreach ($CeoReppy as $key) {
         $htm = $htm.'<td class="py">'.$key.'</td>';
         $restam--;
       }

       for ($i=0; $i < $restam; $i++) { 
        $htm = $htm.'<td class="py"><b></td>'; 
       }
        $htm = $htm.'<td class="acc"><b>'.$ceorepPY1.'</td>';




       $htm = $htm.'
      </tr>';



      $htm = $htm.'
     </tbody>
    </table>';
    return $htm;
    }

    /**
     * Finds the Qhiboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Qhiboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Qhiboard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
