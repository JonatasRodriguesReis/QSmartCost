<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require('Classes/PHPExcel/IOFactory.php');

    $arquivo = '1.xls';

    $tipo = PHPExcel_IOFactory::identify($arquivo);
    $objReader = PHPExcel_IOFactory::createReader($tipo);
    $objPHPExcel = $objReader->load($arquivo);

    $planilha = $objPHPExcel->getSheet(0);
    $ultimaLinha = $planilha->getHighestRow();
    $ultimaColuna = $planilha->getHighestColumn();

    // gera o html
    $html = "<table>";

    // loop em todas as linhas
    for ($linha = 1; $linha <= $ultimaLinha; $linha++) {
        $html .= "<tr>";

        // obtem todos os campos da linha
        $camposLinha = $planilha->rangeToArray("A$linha:$ultimaColuna$linha", NULL, TRUE, FALSE);
        $camposLinha = $camposLinha[0];

        // loop em todos os campos da linha
        for ($campo = 0; $campo < count($camposLinha); $campo++) {
            $html .= "<td>" . $camposLinha[$campo] . "</td>";
        }

        $html .= "</tr>";
    }



    $html .= "</table>";

    // convertendo para HTML.

    //$handle = fopen("exemplo.html", "w");
    //fwrite($handle, $html);
    echo $html;
    
    $drawings = $objPHPExcel->getActiveSheet()->getDrawingCollection(); //gets image collection

$i = 0;

foreach($drawings as $drawing){

if ($drawing instanceof PHPExcel_Worksheet_MemoryDrawing){
ob_start();
call_user_func(
$drawing->getRenderingFunction(),
$drawing->getImageResource()
);
$imageContents = ob_get_contents();
ob_end_clean();
switch ($drawing->getMimeType()){
case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_PNG :

$extension = 'png';
break;
case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_GIF:

$extension = 'gif';
break;
case PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_JPEG :

$extension = 'jpg';
break;
}
} else {
$zipReader = fopen($drawing->getPath(),'r');
$imageContents = "";
while (!feof($zipReader)) {
$imageContents .= fread($zipReader,1024);
}
fclose($zipReader);
$extension = $drawing->getExtension();
}

//Now give your image a name and write it to your folder

$image_name = 'image_'.$i.'.'.$extension;

file_put_contents($image_name,$imageContents);

}

?>