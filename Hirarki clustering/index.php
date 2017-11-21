<?php
include "function.php";


$jumlahClass = 3;

$datasets = getArrayFromCSV("dataset.csv");
$result = hirarkiComplete($datasets,4);
//$result = kmean($datasets,3);
?>

<!DOCTYPE html>
<html>
<head>
  <title>CLUSTERING</title>
</head>
<body>
  <div style="width:300px;float:left;">  
  <h3>Data Sets</h3>
  <table border="1">
      <tr>
        <th>Index.</th>
        <th>x</th>
        <th>y</th>
        <th>Class</th>
      </tr>
    <?php for ($i=0; $i < sizeof($datasets) ; $i++) { ?>
      <tr>
        <td><?php echo $i; ?></td>
      <?php for ($j=0; $j < $jumlahClass; $j++) {  ?>
        <td><?php echo  $datasets[$i][$j] ?></td>
      <?php } ?>
      </tr> 
    <?php 
        }  ?>        
  </table>
  </div>

 
  <?php $num = 1;
    foreach ($result as $data) { ?>
      <div style="margin-left: 20px; float:left;"> 
         <h3>Cluster <?php  echo $num; ?></h3>
         <table border="1">
      <tr>
        <th>Index.</th>
        <th>x</th>
        <th>y</th>
        <th>Class</th>
      </tr>
    <?php for ($i=0; $i < sizeof($data) ; $i++) { ?>
      <tr>
        <td><?php echo $i; ?></td>
      <?php for ($j=0; $j < $jumlahClass; $j++) {  ?>
        <td><?php echo  $data[$i][$j] ?></td>
      <?php } ?>
      </tr> 
    <?php 
        }  ?>        
  </table>
    </div>
      <?php $num++;} ?>


  <!--
  <div style="width:300px;float:left;">  
  <h3>Hasil</h3>
  <table border="1">
      <tr>
        <th>No.</th>
        <th>index1</th>
        <th>index2</th>
        <th>jarak</th>
      </tr>
    <?php for ($i=0; $i < sizeof($result) ; $i++) { ?>
      <tr>
        <td><?php echo $i+1; ?></td>
        <td><?php echo  $result[$i]["index1"] ?></td>
        <td><?php echo  $result[$i]["index2"] ?></td>
        <td><?php echo  $result[$i]["jarak"] ?></td>
      </tr> 
    <?php 
        }  ?>        
  </table>
  </div>-->
</body>
</html>

