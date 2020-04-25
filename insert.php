<?php require_once('conn.php');

ini_set("max_execution_time", 40);
set_time_limit(40);


$IDs = "";

for ($j=20; $j <= 30; $j++) {
  for ($i=2; $i <= 8; $i++) {

  	if($i == 4){
  		$i = 5;
  	}

  	$mlDrink = rand(10, 120).'0';
	$hora = rand(10, 23);
	$minutos = rand(10, 59);
	$segundos = rand(10, 59);

	$querySQL = "INSERT INTO bvzfdagnfqepipz70gyw.drinks(userID, dateDrink, mlDrink) VALUES";// (1, '2019-12-09 00:00:00', 'Sapato', 90.50)
	$querySQL .= "(".$i.", '2020-04-".$j." ".$hora.":".$minutos.":".$segundos."', ".$mlDrink.")";
	// print_r($querySQL);

	$query = $pdo->prepare($querySQL);
    $query->execute();

    if($query->rowCount()){
      $idItem = $pdo->lastInsertId();
      $IDs .= $idItem.", ";

	}else{
	  echo json_encode("Query que não funcionou: ".$querySQL);
	}

	// echo "<br />";
  }

  // echo "<br /><br />";
}

if($IDs <> ''){
	echo json_encode("IDs inseridos: ".substr($IDs, 0, -2));
}

?>