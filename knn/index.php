<?php
include "knn.php";

$error = array
(0,0,0);
$jumlahClass = 5;

//holdout
//$class[0] = getClassArrayFromCSV("iris.csv","Iris-setosa");
//$class[1] = getClassArrayFromCSV("iris.csv","Iris-versicolor");
//$class[2] = getClassArrayFromCSV("iris.csv","Iris-virginica");
//$datasets = holdoutMethod($class,80);

//random subsampling
$class = getArrayFromCSV("iris.csv");
$datasets = bootstrap($class,20);
//$datasets = randSubSampling($class,20);
?>

<!DOCTYPE html>
<html>
<head>
	<title>KNN</title>
</head>
<body>
  <div style="width:300px;float:left;">  
  <h3>Data Training</h3>
  <table border="1">
      <tr>
        <th>No.</th>
        <th>SL</th>
        <th>SW</th>
        <th>PL</th>
        <th>PW</th>
        <th>Class</th>
      </tr>
    <?php for ($i=0; $i < sizeof($datasets["training"]) ; $i++) { ?>
      <tr>
        <td><?php echo $i+1; ?></td>
      <?php for ($j=0; $j < $jumlahClass; $j++) {  ?>
        <td><?php echo  $datasets["training"][$i][$j] ?></td>
      <?php } ?>
      </tr> 
    <?php 
        }  ?>        
  </table>
  </div>

  <div style="width:800px;float:left;">  
  <h3>Data Testing</h3>
  <table border="1">
      <tr>
        <th>No.</th>
        <th>SL</th>
        <th>SW</th>
        <th>PL</th>
        <th>PW</th>
        <th>Actual Class</th>
        <th>Hasil KNN K-1</th>
        <th>Hasil KNN K-3</th>
        <th>Hasil KNN K-5</th>
      </tr>
    <?php for ($i=0; $i < sizeof($datasets["testing"]) ; $i++) { ?>
      <tr>
        <td><?php echo $i+1; ?></td>
      <?php for ($j=0; $j < $jumlahClass; $j++) {  ?>
        <td><?php echo  $datasets["testing"][$i][$j] ?></td>

      <?php } ?>
        <td><?php echo knn($datasets["training"],$datasets["testing"][$i],1);?></td>
        <td><?php echo knn($datasets["training"],$datasets["testing"][$i],3);?></td>
        <td><?php echo knn($datasets["training"],$datasets["testing"][$i],5);?></td>
      </tr> 
    <?php 
        if(knn($datasets["training"],$datasets["testing"][$i],1)!= $datasets["testing"][$i][$jumlahClass-1]){
          $error[0]++; 
        }
        if(knn($datasets["training"],$datasets["testing"][$i],3)!= $datasets["testing"][$i][$jumlahClass-1]){
          $error[1]++;
        }
        if(knn($datasets["training"],$datasets["testing"][$i],5)!= $datasets["testing"][$i][$jumlahClass-1]){
          $error[2]++;
        }
      } 
       ?>      
      <tr>
          <td colspan="6">Error Presentation</td>
          <td><?php echo ($error[0]/sizeof($datasets["testing"]))*100; ?>%</td>
          <td><?php echo ($error[1]/sizeof($datasets["testing"]))*100; ?>%</td>
          <td><?php echo ($error[2]/sizeof($datasets["testing"]))*100 ?>%</td>
      </tr>  
  </table>
  </div>
</body>
</html>

