<?php
include "function.php";

$jumlahAtributt = 3;
$datasets = getArrayFromCSV("dataset.csv");


?>


<!DOCTYPE html>
<html>
<head>
  <title>NAIVE BAYES</title>
</head>
<body>
  <div>  
  <h3>Data Sets</h3>
  <table border="1">
      <tr>
        <th>Index.</th>
        <th>Cuaca</th>
        <th>Suhu</th>
        <th>Angin</th>
        <th>Apakah Berolahraga ?</th>
      </tr>
    <?php for ($i=0; $i < sizeof($datasets) ; $i++) { ?>
      <tr>
        <td><?php echo $i; ?></td>
      <?php for ($j=0; $j <= $jumlahAtributt; $j++) {  ?>
        <td><?php echo  $datasets[$i][$j] ?></td>
      <?php } ?>
      </tr> 
    <?php 
        }  ?>  
      <tr>
        <td colspan="5"><b>Data Testing</b></td>
      </tr>  
      <tr>
        <form action="index.php" method="post">
        <td></td>
        <td><input type="text" name="cuaca" placeholder="cuaca"></td>
        <td><input type="text" name="suhu" placeholder="suhu"></td>
        <td><input type="text" name="angin" placeholder="angin"></td>
        <td><input type="submit" name="go" value="Apakah Berolahraga ?"></input></td>
        </form>   
      </tr>      
  </table>
  </div>
  <br>
  </body>
</html>

<?php

  if(isset($_POST["go"])){
    $cuaca = $_POST["cuaca"];
    $suhu = $_POST["suhu"];
    $angin = $_POST["angin"];

    echo "kesimpulanya ".naive_bayes($datasets,array($cuaca,$suhu ,$angin),array("Ya","Tidak"));
  }

?>

