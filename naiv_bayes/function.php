<?php

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
		if($flag) { $flag = false; continue; }  		 
  		$data[] = $line;
	}
	fclose($file);
	return $data;
}

function naive_bayes($data,$testing,$classOption){

	$terbesar = 0 ;
	for($lup=0; $lup < sizeof($classOption); $lup++){		
		$totalProb = 1;
		for ($i=0; $i < sizeof($testing); $i++) { 
		
			if(empty($testing[$i])){ continue;}
			$nRowClass = 0;
			$nRowAttributonClass = 0;
			foreach ($data as $value) {
				if($value[sizeof($value)-1] == $classOption[$lup]){
					$nRowClass++;
				}

				if($value[sizeof($value)-1] == $classOption[$lup] && $testing[$i] == $value[$i]){
					$nRowAttributonClass++;		
				}
			}
			$prob = ($nRowAttributonClass/sizeof($data)) / ($nRowClass/sizeof($data)) ;
			$totalProb = $totalProb * $prob;

		}
		$ClassProb = $totalProb * ($nRowClass/sizeof($data));
		$result[$lup]["probabilitas"] = $ClassProb;
		$result[$lup]["class"] = $classOption[$lup];
		if($ClassProb > $terbesar){
			$terbesar = $ClassProb;
			$final = $classOption[$lup];
		}
	}

	foreach ($result as $value) {
		echo "Probailitas ".$value["class"]." sebesar ".$value["probabilitas"]."<br>";
	}

	if($terbesar === 0){
		return $classOption[0];//" jika probabilitas sama sama 0";
	}else{		
		return $final;
	}

}

