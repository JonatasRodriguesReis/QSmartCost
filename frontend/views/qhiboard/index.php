<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\QhiboardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'QHI Board';
//$this->params['breadcrumbs'][] = $this->title;

$connection = Yii::$app->getDb();
function semana_do_ano($dia,$mes,$ano){

        $var=intval( date('z', mktime(0,0,0,$mes,$dia,$ano) ) / 7 ) + 1;

        return $var;
        }

          function impr1($lp, $ap){
            
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
                $var = 0;
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
          
        $colspan = sizeof($week_total)+2;
        $htm = '<table href="#" id="weekly-table" style="height: 400px"class="table table-striped table-condensed table-hover">
                      <thead>
                <tr style="text-align: center; font-size:110%;">
                 <th style="vertical-align: middle; text-align: center;" colspan="3" rowspan="2">KPI</th>

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

                foreach ($week_total as $key) {
                  $htm = $htm.'<td style="vertical-align: middle; text-align: center;"width="70px"> <b>W'.$key.'</td>';
                }

                $htm = $htm.'

                 <td style="vertical-align: middle; text-align: center;"> <b>Acc. </td>
                 <td style="vertical-align: middle; text-align: center;"> <b>YOY</td>
                </tr>
                </thead>
                <tbody>
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="6" style="vertical-align: middle" bgcolor="#e0e0e0">Market</td>
                 <td rowspan="3" style="vertical-align: middle" bgcolor="#e0e0e0" title="Failure Field Rate">FFR </td>
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
                <tr  bgColor="#e0e0e0" style="text-align: center; font-size:110%;">
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
              $ptsFFR = ($ptsFFR/5)*35;


              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td bgcolor="#e0e0e0" class="week"></td>';
              }

              $p = ($ptsFFR/35)*100;
              $htm = $htm.'
                 <td bgColor="#e0e0e0" class="ap"><b>'.$Acc.'</td>
                 <td bgcolor="#e0e0e0"'.$yoy.'</td>
                 <td bgColor="#e0e0e0" class="patt">35</td>
                 <td bgColor="#e0e0e0" class="pts" >'.$ptsFFR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';
        // AQUI COMEÇA O FCR
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                 <td rowspan="3" style="vertical-align: middle"title="Failure Cost Rate" bgcolor="#e0e0e0">FCR </td>
                 <td>Failure cost</td>
                 <td class="lp"><b>'.$fc.'</td>
                 <td class="ao"><b>60,4</td>';

              $restam = sizeof($week_total);
              $soma = 0;
              foreach ($FCR1 as $key) {
                $htm = $htm.'<td class="week">'.$key."</td>";
                $restam--;
                $soma += $key;
              }
              $insert1 = $soma;
              $yoy = impr1($fc,$soma);

              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $htm = $htm.'
                 <td class="ap"><b>'.$soma.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                 <td>Sales</td>
                 <td class="lp"><b>'.$sales.'</td>
                 <td class="ao"><b>13802</td>';
                 $soma1 = 0;
              foreach ($FCR2 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
                $soma1 += $key;
              }
              $insert2 = $soma1;
              
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }

              $yoy = impr2($sales,$soma1);
                 $htm = $htm.'
                 <td class="ap"><b>'.$soma1.'</td>
                 <td '.$yoy.'</td>
                </tr>
                <tr bgcolor="#e0e0e0" style="text-align: center; font-size:110%;">
                 <td >Rate </td>
                 <td class="lp"><b>'.$rateFCR.'</td>
                 <td class="ao"><b>0.44</td>';
              foreach ($FCR3 as $key) {
                $htm = $htm.'<td class="week">'.$key.'</td>';
              }
              for ($i=0; $i < $restam; $i++) { 
                $htm = $htm.'<td class="week"></td>';
              }
              if($soma1 != 0){
                $soma = round($soma/$soma1*100,2);
              }
              $insert3 = $soma;

              $command = $connection->createCommand("SELECT COUNT(*) FROM lg.fcr_acc WHERE month = ".$month." AND year = ".$year." ORDER BY id DESC");
                $result = $command->queryAll();
                foreach ($result as $perk) {
                  $qtd = $perk['COUNT(*)'];
                  break;
                }
                if ($qtd > 0) {
                  $command = $connection->createCommand("UPDATE lg.fcr_acc SET fail=".$insert1.",sales=".$insert2.",rate=".$insert3." WHERE month = ".$month." AND year = ".$year.";");
                  $sql_result = $command->execute();
                }else{
                $command = $connection->createCommand("INSERT INTO lg.fcr_acc (fail,sales,rate,month,year) VALUES (:fail,:sales,:rate,:month,:year)");
                $command->bindValue(':fail', $insert1);
                $command->bindValue(':sales', $insert2);
                $command->bindValue(':rate', $insert3);
                $command->bindValue(':month', $month);
                $command->bindValue(':year', $year);
                $sql_result = $command->execute();
              }
              $yoy = impr1($rateFCR,$soma);
              $y = i1($rateFCR,$soma);
              
              if ($y >= 2) $ptsFCR = 5;
              elseif ($y >= 1) $ptsFCR = 4;
              elseif ($y >= 0) $ptsFCR = 3;
              elseif ($y >= -1) $ptsFCR =  2;
              else $ptsFCR =  1;
              $ptsFCR = ($ptsFCR/5)*20;

                $p = ($ptsFCR/20)*100;
                $htm = $htm.'
                 <td class="ap"><b>'.$soma.'</td>
                 <td bgcolor="#e0e0e0"'.$yoy.'</td>
                 <td class="patt">20</td>
                 <td bgColor="#e0e0e0" class="pts" >'.$ptsFCR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';

                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                <td rowspan="9" style="vertical-align: middle" bgColor="#e0e0e0">Production</td>
                <td rowspan="3" style="vertical-align: middle" bgColor="#e0e0e0" title="Parts Return Rate">PRR</td>
                <td>Defect Quantity</td>
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
                <td>Production Quantity</td>
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
                <tr style="text-align: center; font-size:110%;" bgColor="#e0e0e0">
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
                <td bgcolor="#e0e0e0"'.$yoy.'</td>
                <td bgColor="#e0e0e0" class="patt">15</td>
                <td bgColor="#e0e0e0" class="pts" >'.$ptsPRR.'</td>
                <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';
                
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%;">
                <td rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Total Line Defect Rate"bgColor="#e0e0e0">TLDR</td>
                <td>Defect Quantity</td>
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
                <td>Production Quantity</td>
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
                <tr style="text-align: center; font-size:110%;" bgColor="#e0e0e0">
                <td>PPM</td>
                <td class="lp"><b>'.$ppmTLDR.'</td>
                <td class="ao"><b>4200</td>';
                 
                if($soma1 != 0){
                  $soma = round(($soma/$soma1)*1000000);
                }

                foreach ($TLDR3 as $key) {
                  $htm = $htm.'<td class="week">'.$key.'</td>';
                }
                for ($i=0; $i < $restam; $i++) { 
                  $htm = $htm.'<td class="week"></td>';
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
                $ptsTLDR = ($ptsTLDR/5)*15;
                $p = ($ptsTLDR/15)*100;
                $htm = $htm.'<td class="ap"><b>'.$soma.'</td>
                <td bgcolor="#e0e0e0"'.$yoy.'</td>
                <td class="patt">15</td>
                <td bgColor="#e0e0e0" class="pts" >'.$ptsTLDR.'</td>
                <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>';

        // IFRR começa aqui
                $htm = $htm.'
                <tr style="text-align: center; font-size:110%">
                <td rowspan="3" style="text-align: center; font-size:110%; vertical-align: middle" title="Intern Failure Rework Rate" bgColor="#e0e0e0">IFRR </td>
                <td>Rework Quantity</td>
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
                  <td>Production Quantity</td>
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
                </tr>
                <tr bgColor="#e0e0e0" style="text-align: center; font-size:110%;">
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
                $colspan = 2+$colspan-1;
                 
                $yoy = impr1($ppmIFRR,$soma);
                $y = i1($ppmIFRR,$soma);
                $ptsIFRR = pts($ppmIFRR, $y, 5, 3, 1);
                $ptsIFRR = ($ptsIFRR/5)*15;
                $p = ($ptsIFRR/15)*100;
                $somarates = $ptsFFR+$ptsFCR+$ptsPRR+$ptsTLDR+$ptsIFRR;
                $htm = $htm.'
                     <td bgColor="#e0e0e0" class="ap"><b>'.$soma.'</td>
                     <td bgcolor="#e0e0e0"'.$yoy.'</td>
                  <td bgColor="#e0e0e0"class="patt">15</td>
                 <td bgColor="#e0e0e0" class="pts" >'.$ptsIFRR.'</td>
                 <td bgColor="#e0e0e0" class="prctg">'.$p.'%</td>
                </tr>
                <tr style="text-align: center; font-size:110%;">
                <td bgColor="#e0e0e0"colspan = 3>Total</td>
                <td bgColor="#e0e0e0"colspan = '.$colspan.'></td>
                <td></td>
                <td class="patt">100</td>
                <td class="pts">'.$somarates.'</td>
                <td class="prctg">'.$somarates.'%</td>
                </tr>
               </tbody>';
              
              $htm = $htm.'</table>';



$script = <<< JS

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
                      td[i].innerHTML = "<b>"+str;
                  }
                  i++;
                }
          });

          $('#showmonth').click(function(){
            $.ajax({
                url:'?r=qhiboard/month',
                type:'get',
                success:function(data){
                  $('#table').html(data);
                },
                error:function(xhr,ajaxOptions,throwError){
                    alert(throwError);
                }
            });
          });

          $('#showweek').click(function(){
            $.ajax({
                url:'?r=qhiboard/week',
                type:'get',
                success:function(data){
                  $('#table').html(data);
                },
                error:function(xhr,ajaxOptions,throwError){
                    alert(throwError);
                }
            });
          });

          $("button").click(function(){
            $("button").removeClass("active");
            $(this).addClass("active");
          });
    });

JS;

$position = \yii\web\View::POS_READY;
$this->registerJs($script, $position);
$this->registerCss("

th, td{
  text-align:center;
  vertical-align:middle;
  font-size:110%;
}

.active {
  background-color: #dd4b39 !important;
  color: white;
}
  ");


?>
<div class="qhiboard-index">

      <div class="box box-danger">
          <div class="box-header with-border">
              <h1><?= Html::encode($this->title) ?></h1>
          </div>
          
        <button type="button" class="active" id = "showweek"  style="width:400">Tabela Semanal</button>
        <button type="button" id = "showmonth" style="width:200">Tabela Mensal</button>
      <!-- TABELA SEMANAL -->
       <div id = "table">
        <?php echo $htm;?>
      </div>
    </div> 
</div>
