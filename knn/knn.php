<?php

function knn($training,$testing,$k){
	$result = array(); 
	$i=0;

	//hitung jarak
	foreach ($training as $data) {
		$jarak = 0;
		for ($j=0; $j < sizeof($testing)-1 ; $j++) { 
			$jarak =$jarak+(pow(($testing[$j]-$data[$j]), 2));
		}
		//$jarak = pow(($testing[0]-$data[0]), 2)+pow(($testing[1]-$data[1]), 2)+pow(($testing[2]-$data[2]), 2)+pow(($testing[3]-$data[3]), 2);
		$result[$i]["jarak"] = sqrt($jarak);
		$result[$i]["class"] = $data[sizeof($testing)-1];
		$i++;
	}
	
	//sorting array berdasarkana nilai jarak
	usort($result, function($a, $b) {
    	return ($a['jarak'] < $b['jarak']) ? -1 : 1;
	});
	
	//amabil nilai k terratas
	$result = array_slice($result, 0, $k);
	
	//cari nilai yang paling banyak muncul
	$counted = array_count_values(array_map(function($foo){return $foo['class'];}, $result));
	$final = array_search(max($counted ),$counted);
	return $final;
}

function getClassArrayFromCSV($csvPath,$typeClass){
	$file = fopen($csvPath, 'r');
	$flag = true;
	while (($line = fgetcsv($file)) !== FALSE) {
		//if($flag) { $flag = false; continue; }  		 
  		if ($line[4] == $typeClass) {
  			$data[] = $line;
  		}
	}
	fclose($file);
	return $data;
}

function getArrayFromCSV($csvPath){
	$file = fopen($csvPath, 'r');
	$flag = true;
	while (($line = fgetcsv($file)) !== FALSE) {
		//if($flag) { $flag = false; continue; }  		 
  		//if ($line[3] == $typeClass) {
  			$data[] = $line;
  		//}
	}
	fclose($file);
	return $data;
}


function holdoutMethod($data,$presentaseTraining){

	$result["training"] = array();
	$result["testing"] = array();
	foreach ($data as $value) {		
		$jumlahTraining = ($presentaseTraining/100) * sizeof($value);
		$result["training"] = array_merge($result["training"],array_slice($value, 0, $jumlahTraining));
		$result["testing"] = array_merge($result["testing"] , array_slice($value, $jumlahTraining,sizeof($value)-1));
	}	
	return $result;
}

function randSubSampling($data,$jumlahTesting){
	$result["training"] = $data;
	$result["testing"] = array();
	for ($i=0; $i < $jumlahTesting; $i++) { 
		$randomNumber = rand(0,sizeof($result["training"])-1);
		$result["testing"][$i] = $result["training"][$randomNumber];		
		array_splice($result["training"], $randomNumber,1);
	}
	return $result;
}

function bootstrap($data,$jumlahTesting){
	$result["training"] = $data;
	$result["testing"] = array();
	for ($i=0; $i < $jumlahTesting; $i++) { 
		$randomNumber = rand(0,sizeof($result["training"])-1);
		$result["testing"][$i] = $result["training"][$randomNumber];		
		$randomNumberReplace = rand(0,sizeof($data)-1);
		$result["training"][$randomNumber] = $data[$randomNumberReplace];
	}
	return $result;
}

//masih salah. harusnya per class
function kfold($data,$k,$k_ke){
	$result["training"] = array();
	$result["testing"] = array();
	$jumlah_slice =   (int) (sizeof($data) / $k);
	//die();
	$sliceFrom = ($k_ke * $jumlah_slice);
	//echo $sliceFrom."sampai".($sliceFrom + $jumlah_slice);
	if($k_ke == ($k-1)){
		$result["testing"] = array_slice($data,$sliceFrom,sizeof($data)-1);
		array_splice($data,$sliceFrom, sizeof($data)-1);
	}else{
		$result["testing"] = array_slice($data,$sliceFrom,$jumlah_slice);
		array_splice($data,$sliceFrom, $jumlah_slice);
	}
	$result["training"] = $data;
	//print_r($result["training"]);
	//die();
	return $result;
}


