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

//complete linkage
function hirarkiComplete($data,$k){
	//inisialisasi cluster = data
	for ($i=0; $i < sizeof($data) ; $i++) { 
		$clusters[$i] = array();
		array_push($clusters[$i],$data[$i] );
	}

	while($k < sizeof($clusters)){
		//hitung jarak tiap titik
		for ($i=0; $i < sizeof($clusters) ; $i++) { 		
			for ($baris=$i+1; $baris < sizeof($clusters) ; $baris++) { 

				$terjauh = 0;
				foreach ($clusters[$i] as $titik1) {
					foreach ($clusters[$baris] as $titik2) {	
						$jarak = hitungJarak($titik1,$titik2);				
						if($jarak > $terjauh){
							$terjauh = $jarak;
						}
					}					
				
				}	
				$jarak = $terjauh;
				//pertama
				if($i==0 && $baris == $i+1){
					$terpendek = $jarak;
					$index1 = $i;
					$index2 = $baris;
				}else{
					//pengecekan nilai minimal
					if($jarak < $terpendek){
						$terpendek = $jarak;
						$index1 = $i;
						$index2 = $baris;
					}
				}
			}
		}

		//gabung, push lalu hapus
		foreach ($clusters[$index2]  as $cluster) {		
			array_push($clusters[$index1],$cluster );
		}
		array_splice($clusters, $index2,1);
	}

	//print_r($clusters);	
	//die();
	return $clusters;
}

function kmean($data,$k){	
	$centroid = array();
	$clusters = array();

	for ($i=0; $i < $k ; $i++) { 
		for ($j=0; $j < sizeof($data[$i])-1; $j++) { 			
			$centroid[$i][] = rand(1,100);
		}
		//$clusters[$i] = array();
	}


	$is_same = true;
	do{

	for ($i= 0 ; $i < sizeof($data)  ; $i++) { 
		for ($j=0; $j < sizeof($centroid); $j++) { 
			$jarak = hitungJarak($data[$i],$centroid[$j]);
			if($j==0){
				$terpendek = $jarak;
				$clusterKe = $j;
			}else{
				//pengecekan nilai minimal
				if($jarak < $terpendek){
					$terpendek = $jarak;
					$clusterKe = $j;
				}
			}
		}
		$clusters[$clusterKe][] = $data[$i];
	}
	
	//tentukan titik baru

	$newCentroid = array();
	for ($i=0; $i < sizeof($clusters); $i++) { 
		if(sizeof($clusters[$i])==0){
			$newCentroid[$i] = $centroid[$i];
			continue;
		}
		for ($baris=0; $baris < sizeof($clusters[$i]); $baris++) { 				
			for ($kolom=0; $kolom < sizeof($clusters[$i][$baris])-1 ; $kolom++) { 
				if($baris==0){
					$newCentroid[$i][$kolom]=0;
				}
				$newCentroid[$i][$kolom] =  $newCentroid[$i][$kolom]+$clusters[$i][$baris][$kolom];				
			}
		}

		for ($kolomNewCentroid=0; $kolomNewCentroid <sizeof($newCentroid[$i]) ; $kolomNewCentroid++) { 
			$newCentroid[$i][$kolomNewCentroid] = $newCentroid[$i][$kolomNewCentroid] / $baris;
			if($newCentroid[$i][$kolomNewCentroid] != $centroid[$i][$kolomNewCentroid]){
				$is_same = false;
			}
		}	
	}
	}while($is_same==true);


	return $clusters;
}



function hitungJarak($titik1,$titik2){
	$jarak = 0;
	for ($j=0; $j < sizeof($titik1)-1 ; $j++) { 
		$jarak = $jarak+(pow(($titik1[$j]-$titik2[$j]), 2));
	}
	return sqrt($jarak);	
}