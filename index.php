<?php require_once("conn.php");

if(isset($_SERVER["REQUEST_URI"]) && $_SERVER["REQUEST_URI"] <> ''){
  // echo $_SERVER['PHP_SELF']."<br />";
  $path = explode('/', $_SERVER['PHP_SELF']);

  foreach ($path as $key => $value) {
  	// echo $value."<br />";
  	unset($path[$key]);
  	if($value == "index.php"){
  		break;
  	}
  }

  $path = array_values($path);

}else{
  finalDialogue(2, "URL não informada", null);
}


$rqMethod = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents('php://input');
$jsonBody = json_decode($body, true);
executeProgram($rqMethod, $path, $jsonBody, $pdo, $md5);


//finalDialogue(1, "Téste: '".$rqMethod."'", null);


?>