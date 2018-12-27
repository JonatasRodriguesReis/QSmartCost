<?php

$input = "NOV'18";
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
//$htm= '<table class="table table-bordered" ><tr>';
$htm = '<thead style="background-color:#b71c1c;color:#fff">
		<tr >
			<th></th>
';

$dias_total = array();

foreach ($list as $data) {
	//print_r(substr($data,0,-4). " ");
	if(!(substr($data,-3) == 'Sun' || substr($data,-3) == 'Sat')){
		$htm = $htm . '<th>'. substr($data, -6,-4) .'</th>';
		//print_r($data." ");
		array_push($dias_total,substr($data, -6,-4));
		
	}
	
}
//print_r($dias_total[0]."-<");
$htm = $htm.'</tr></thead><tbody>';

$items = array('Item1 MWO IQC6','Item2 RAC IQC6');
foreach ($items as $key) {
	$htm = $htm . '<tr><td>' . $key . '</td>';
	foreach ($dias_total as $dia) {
		//print_r(substr($datas_total($i),0,-4) );
		$htm = $htm .'
			<td>
                <div class="radio">
                    <label>
                      <input type="radio" name="radios_'. $key .'" id="radio_"' . $key.'_'. $dia .'" value="'. $dia .'" >
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

//echo (substr($input, 0,-3));
//echo (substr($input, 4));


