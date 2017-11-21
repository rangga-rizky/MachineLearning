<?php
include "knn.php";

$totalError = array
(0,0,0);
$jumlahClass = 5;
$k = 3;
//holdout
//$class[0] = getClassArrayFromCSV("iris.csv","Iris-setosa");
//$class[1] = getClassArrayFromCSV("iris.csv","Iris-versicolor");
//$class[2] = getClassArrayFromCSV("iris.csv","Iris-virginica");
//$datasets = holdoutMethod($class,50);

//random subsampling
$class = getArrayFromCSV("iris.csv");
//$datasets = randSubSampling($class,1);


//kfold
?>

<!DOCTYPE html>
<html>
<head>
  <title>KNN</title>
</head>
<body>



<?php
 for ($lup=0; $lup < $k; $lup++) { 
  $error = array
  (0,0,0);
   
    $datasets = kfold($class,$k,$lup);

  ?>  
  

    <div style="display: inline-block;">  
  <h3>Data Testing K=<?php echo $lup+1?></h3>
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
  </div>

<?php 
    $totalError[0] = $totalError[0] + (($error[0]/sizeof($datasets["testing"]))*100);
    $totalError[1] = $totalError[1] + (($error[1]/sizeof($datasets["testing"]))*100);
    $totalError[2] = $totalError[2] + (($error[2]/sizeof($datasets["testing"]))*100);
} ?>

<br>
<h5>Rata Rata error</h5>
1-nn = <?php echo $totalError[0]/$k?> %<br>
3-nn = <?php echo $totalError[1]/$k?> %<br>
5-nn = <?php echo $totalError[2]/$k?> %<br>
</body>
</html>

