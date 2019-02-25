<?php

header("Content-Type: application/json; charset=UTF-8");

date_default_timezone_set('America/Manaus');
$dia = date('d');
$mes = date('m');
$ano = date('Y');
//echo $dia.'-'.$mes.'-'.$ano;
$conn = new mysqli("localhost", "root", "alberto14", "lg");
$result = $conn->query("SELECT inspetor_iqc, item, inicio_inspecao, fim_inspecao 
						FROM lg.load 
						WHERE inicio_inspecao BETWEEN '$ano-$mes-$dia 00:00:00' AND '$ano-$mes-$dia 23:59:59' AND status LIKE 'DONE'");
$outp = array();
$outp = $result->fetch_all(MYSQLI_ASSOC);
 
echo (json_encode($outp));


?>