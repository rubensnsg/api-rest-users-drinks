<?php session_start();

header('Content-Type: application/json; charset=utf-8');
date_default_timezone_set('America/Sao_Paulo');

$nomeSite = 'Mosyle';
$md5 = 'M0SYL3';

/* BANCO DE DADOS FREE - CONTEM TABELAS USADAS EM OUTROS TESTES  */
$host_bd = 'bvzfdagnfqepipz70gyw-mysql.services.clever-cloud.com';
$username_bd = 'ufgpsjx1cswrmye3';
$password_bd = 'ZoKM7HXwAaZAgd9ugpTr';
$nome_bd = 'bvzfdagnfqepipz70gyw';


try{
  $pdo = new PDO('mysql:host='.$host_bd.';dbname='.$nome_bd, $username_bd, $password_bd);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}catch(PDOException $e){
  finalDialogue(2, "Erro no acesso ao banco de dados.", null);
  //echo 'Erro no acesso ao banco de dados:<br />' . $e->getMessage();
}


/*
  int $status - 0 error, 1 OK, 2 WARNING
  string  $response - opcional
  array   $dataArray - exit in doc
*/

function finalDialogue($status, $response = null, $dataArray = array()){
  echo json_encode(
    array(
      'status' => $status,
      'response' => $response,
      'dataArray' => $dataArray
    )
  );
  exit;
}

/*
  string  $rqMethod - POST, GET, PULL, DELETE
  array   $path - routers
  array   $json - send
          $pdo - var Connection
  string  $md5 - Global var with term to encrypt
*/
function executeProgram($rqMethod, $path = array(), $json, $pdo, $md5){

  //print_r($path);

  switch ($rqMethod) {
    case 'GET':

      checkTokenSession();

      if(isset($path[0]) && $path[0] == "users"){
        
        $table = "bvzfdagnfqepipz70gyw.users";
        $columns = array("iduser", "name", "email", "(SELECT COUNT(mlDrink) FROM drinks WHERE userID = iduser) qtdDrink");
        $where = "ORDER BY iduser ASC";
        $parameters = array();
        $pageNumberGet = 1;
        $quantityPerPage = 2;

        if(isset($path[1]) && $path[1] <> ""){

          if(is_numeric($path[1])){
            $where = "WHERE iduser = ? ".$where;
            $parameters[0] = $path[1];

          }elseif($path[1] == "page"){

            if(isset($path[2]) && is_numeric($path[2])){
              $pageNumberGet = $path[2];
            }

          }else{

          }

        }else{

        }

        $paginationSQL = PaginationSelect($table, "iduser", $where, $parameters, $pageNumberGet, $quantityPerPage, $pdo);
        $where .= $paginationSQL['limitSQL'];
        // exit(json_encode($where));

        $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);

        if(count($rowSQL) > 0){

          foreach ($rowSQL as $key => $value) {
            $selectSQl[$key] = array("iduser" => $value['iduser'],
                                      "name" => $value['name'],
                                      "email" => $value['email'],
                                      "drink_counter" => $value['qtdDrink']);
          }

          $jsonExit = array('RowPerPage' => (string) $quantityPerPage,
                            'TotalRows' => $paginationSQL['countSQL'],
                            'FirstPage' => $paginationSQL['paginationStart'],
                            'ActualPage' => $paginationSQL['paginationNow'],
                            'LastPage' => $paginationSQL['paginationEnd'],
                            'Rows' => $selectSQl);

          /* countSQL
          print_r($jsonExit);
          exit;
          */

          finalDialogue(1, "Select com sucesso", $jsonExit);

        }else{
          finalDialogue(2, "Sem registro de usuários.", null);
        }
      }

      break;

    case 'POST':

      if(isset($path[0]) && $path[0] == "historic"){
        
        checkTokenSession();

        if(isset($path[1]) && $path[1] <> '' && is_numeric($path[1])){

          $table = "bvzfdagnfqepipz70gyw.users";
          $columns = array("iduser", "name", "email", "password");
          $where = "WHERE iduser = ? ORDER BY iduser ASC";
          $parameters[0] = $path[1];

          $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);
          //print_r($rowSQL);

          if(count($rowSQL) > 0){

            $table = "bvzfdagnfqepipz70gyw.drinks";
            $columns = array("DATE_FORMAT(dateDrink, '%d/%m/%Y %H:%i') timetable", "mlDrink");
            $where = "WHERE userID = ? ORDER BY dateDrink DESC";

            $drinkSQL = selectSQL($table, $columns, $where, $parameters, $pdo);


            if(count($drinkSQL) > 0){
              $selectSQl = array();

              foreach ($drinkSQL as $key => $value) {
                $selectSQl[$key] = array("timetable" => $value['timetable'],
                                          "mlDrink" => $value['mlDrink']." ml");
              }
            }else{
              $selectSQl = "Sem resultados.";
            }

            $jsonExit = array('iduser' => $path[1], 'user' => $rowSQL[0]['name'], 'email' => $rowSQL[0]['email'], 'historic' => $selectSQl);

            finalDialogue(1, "Histórico", $jsonExit);

          }else{
            finalDialogue(2, "Não existe usuário com o ID informado. Por favor, verifique o campo e tente novamente.", null);
          }

        }else{
          finalDialogue(2, "Campo ID usuário não foi encontrado. Por favor, verifique o campo e tente novamente.", null);
        }
      }

      if(isset($path[0]) && $path[0] == "ranking"){
        
        checkTokenSession();

        $table = "bvzfdagnfqepipz70gyw.users";
        $dateToday = date("Y-m-d");
        $columns = array("name", "IF(EXISTS(SELECT mlDrink FROM drinks WHERE DATE(dateDrink) = '".$dateToday."' AND userID = iduser AND mlDrink > 0), (SELECT SUM(mlDrink) FROM drinks WHERE DATE(dateDrink) = '".$dateToday."' AND userID = iduser), '0') mlTotal");
        $where = " ORDER BY CAST(mlTotal AS UNSIGNED) DESC, name ASC ";
        $parameters = array();

        $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);

        $selectSQl = array();

        foreach ($rowSQL as $key => $value) {
          $selectSQl[$key] = array("position" => ($key + 1),
                                    "name" => $value['name'],
                                    "mlTotal" => $value['mlTotal']);
        }

        $jsonExit = array('total' => count($rowSQL), 'rows' => $selectSQl);

        finalDialogue(1, "Ranking ".dataBR($dateToday), $jsonExit);
      }

      if(isset($path[0]) && $path[0] == "users"){

        if(isset($path[1]) && $path[1] <> '' && is_numeric($path[1]) && isset($path[2]) && $path[2] == "drink"){
          
          checkTokenSession();
          checkStringNoNull($json, 'mlDrink');
        
          $table = "bvzfdagnfqepipz70gyw.users";
          $columns = array("iduser", "name", "email", "(SELECT COUNT(mlDrink) FROM drinks WHERE userID = iduser) qtdDrink");
          $where = "WHERE iduser = ? ORDER BY iduser ASC";
          $parameters[0] = $path[1];

          $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);
          //print_r($rowSQL);

          if(count($rowSQL) > 0){

            $table2 = "bvzfdagnfqepipz70gyw.drinks";
            insertSQL($table2, array('userID' => $rowSQL[0]['iduser'],
                                    'dateDrink' => date("Y-m-d H:i:s"),
                                    'mlDrink' => $json['mlDrink']), $pdo);

            $jsonExit = array('iduser' => $rowSQL[0]['iduser'],
                              'email' => $rowSQL[0]['email'],
                              'name' => $rowSQL[0]['name'],
                              'drink_counter' => ($rowSQL[0]['qtdDrink'] + 1) );

            finalDialogue(1, "Insert realizado com sucesso", $jsonExit);

          }else{
            finalDialogue(2, "Não existe usuário com o ID informado. Por favor, verifique o campo e tente novamente.", null);
          }

        }else{
          checkStringNoNull($json, 'name');
          checkStringNoNull($json, 'password');

          $name = $json["name"];
          $password = $md5.$json["password"];
          $password = hash('sha256', $password);

          checkStringNoNull($json, 'email');
          $email = filter_var($json["email"], FILTER_SANITIZE_EMAIL);

          // Validate e-mail
          if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            checkEmailExistsonDB($email, '', $pdo);
          } else {
            finalDialogue(2, "Email não foi validado. Por favor, verifique o campo e tente novamente.", null);
          }

          $table = "bvzfdagnfqepipz70gyw.users";
          insertSQL($table, array('email' => $email,
                                  'password' => $password,
                                  'name' => $name), $pdo);
        }
      }

      if(isset($path[0]) && $path[0] == "login"){

        checkStringNoNull($json, 'password');
        $password = $md5.$json["password"];
        $password = hash('sha256', $password);

        checkStringNoNull($json, 'email');
        $email = filter_var($json["email"], FILTER_SANITIZE_EMAIL);

        // Validate e-mail
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
          
          $table = "bvzfdagnfqepipz70gyw.users";
          $columns = array("iduser", "name", "password", "(SELECT COUNT(mlDrink) FROM drinks WHERE userID = iduser) qtdDrink");
          $where = "WHERE email = ?";
          $parameters = array($email);

          $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);
          //print_r($rowSQL);

          if(count($rowSQL) > 0){
            //echo $rowSQL[0]["password"]." = ".$password."<br />";
            if(trim($rowSQL[0]["password"]) == trim($password)){

              $tokenUser = createToken(trim($rowSQL[0]["iduser"]), $email, '1', $md5);
              // echo "<br />Token: ".$tokenUser;

              $jsonExit = array('token' => $tokenUser,
                                'iduser' => trim($rowSQL[0]["iduser"]),
                                'email' => $email,
                                'name' => trim($rowSQL[0]["name"]),
                                'drink_counter' => trim($rowSQL[0]["qtdDrink"]),
                                );
              finalDialogue(1, "Login realizado com sucesso", $jsonExit);

            }else{
              finalDialogue(2, "Senha informada difere do banco de dados. Por favor, verifique o campo senha.", null);
            }

          }else{
            finalDialogue(2, "Email não cadastrado. Por favor, crie seu usuário ou verifique o campo e tente novamente.", null);
          }

        } else {
          finalDialogue(2, "Email não foi validado. Por favor, verifique o campo e tente novamente.", null);
        }

        /*
        $table = "bvzfdagnfqepipz70gyw.users";
        insertSQL($table, array('email' => $email,
                                'password' => $password,
                                'name' => $name), $pdo);
        */
      }
      break;


    case 'PUT':

      $tokenRecebido = checkTokenSession();

      if(isset($path[0]) && $path[0] == "users"){

        if(isset($path[1]) && $path[1] <> '' && is_numeric($path[1])){

          checkStringNoNull($json, 'name');
          checkStringNoNull($json, 'password');

          $name = $json["name"];
          $password = $md5.$json["password"];
          $password = hash('sha256', $password);

          checkStringNoNull($json, 'email');
          $email = filter_var($json["email"], FILTER_SANITIZE_EMAIL);

          // Validate e-mail
          if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            checkEmailExistsonDB($email, ' AND iduser <> '.$path[1], $pdo);
          } else {
            finalDialogue(2, "Email não foi validado. Por favor, verifique o campo e tente novamente.", null);
          }

          $table = "bvzfdagnfqepipz70gyw.users";
          $columns = array("iduser", "name", "email", "password");
          $where = "WHERE iduser = ? ORDER BY iduser ASC";
          $parameters[0] = $path[1];

          $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);
          //print_r($rowSQL);

          if(count($rowSQL) > 0){

            $tokenUserSQL = createToken($rowSQL[0]["iduser"], $rowSQL[0]["email"], '0', $md5);
            $tokenNovoSQL = createToken($parameters[0], $email, '0', $md5);
            
            //echo $tokenRecebido." = ".$tokenUserSQL." = ".$tokenNovoSQL."<br />";

            if(trim($tokenRecebido) == trim($tokenUserSQL)){
            
              if($name == $rowSQL[0]["name"] && $email == $rowSQL[0]["email"] && $password == $rowSQL[0]["password"]){
                
                finalDialogue(1, "Dados enviados são iguais aos encontrados no banco de dados.", null);

              }else{

                $columns = array("email", "name", "password");
                $parameters = array($email, $name, $password, $path[1]);

                updateSQL($table, $columns, $where, $parameters, $pdo);

                if($tokenUserSQL == $tokenNovoSQL){
                  finalDialogue(1, "Dados atualizados com sucesso no banco de dados.", null);

                }else{
                  $_SESSION['token'] = $tokenNovoSQL;
                  finalDialogue(1, "Dados atualizados com sucesso no banco de dados. Por favor faça o login novamente", null);
                }
              }

            }else{
              finalDialogue(0, "Você só pode editar os dados do seu usuário.", null);
            }

          }else{
            finalDialogue(2, "Não existe usuário com o ID informado. Por favor, verifique o campo e tente novamente.", null);
          }

        }else{
          finalDialogue(2, "Campo ID usuário não foi encontrado. Por favor, verifique o campo e tente novamente.", null);
        }
      }

      break;


    case 'DELETE':

      $tokenRecebido = checkTokenSession();

      if(isset($path[0]) && $path[0] == "users"){

        if(isset($path[1]) && $path[1] <> '' && is_numeric($path[1])){

          $table = "bvzfdagnfqepipz70gyw.users";
          $columns = array("iduser", "name", "email", "password");
          $where = "WHERE iduser = ? ORDER BY iduser ASC";
          $parameters[0] = $path[1];

          $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);
          //print_r($rowSQL);

          if(count($rowSQL) > 0){

            $tokenUserSQL = createToken($rowSQL[0]["iduser"], $rowSQL[0]["email"], '0', $md5);

            if(trim($tokenRecebido) == trim($tokenUserSQL)){

              deleteSQL($table, $where, $parameters, $pdo);

              $table = 'bvzfdagnfqepipz70gyw.drinks';
              $where = 'WHERE userID = ?';
              deleteSQL($table, $where, $parameters, $pdo);
              
              unset($_SESSION['token']);

            }else{
              finalDialogue(0, "Você só pode excluir o seu usuário.", null);
            }

          }else{
            finalDialogue(2, "Não existe usuário com o ID informado. Por favor, verifique o campo e tente novamente.", null);
          }

        }else{
          finalDialogue(2, "Campo ID usuário não foi encontrado. Por favor, verifique o campo e tente novamente.", null);
        }
      }

      break;
    
    default:
      finalDialogue(2, "Parâmetro não enviado", null);
      break;
  }
}


/*
  string  $table - table name on Database
  array   $columns - All fields, key = column name on Database and value = value to insert
          $pdo - var Connection
*/
function insertSQL($table, $columns = array(), $pdo){

  $querySQL = "INSERT INTO ".$table."(".implode(", ",array_keys($columns)).") VALUES(:".implode(", :",array_keys($columns)).")";
  // print_r($querySQL);
  $query = $pdo->prepare($querySQL);
  foreach ($columns as $key => $value) {
    $query->bindValue($key,  $value);
    // echo "<br />".$key." - ".$value;
  }
  $query->execute();
  
  if($query->rowCount()){
    // $idItem = $pdo->lastInsertId();
    // finalDialogue(1, "Usuário inserido com sucesso.", array($idItem));   

  }else{
    finalDialogue(0, "Erro ao executar insert sql. Por favor, tente novamente mais tarde.", null);    
  }
}


/*
  string  $table - table name on Database
  array   $columns - only values, fields to select SQL
  string  $where - Clause where complete to select on mysql, Opcional group by, order
  array   $parameters - only values, string to bindValue
          $pdo - var Connection

  return = array $returnValues
*/
function updateSQL($table, $columns, $where, $parameters, $pdo){

  $querySQL = "UPDATE ".$table." SET ".implode(" = ? , ", $columns)." = ? ".$where." ";
  //print_r($querySQL);

  $query = $pdo->prepare($querySQL);
  //echo count($parameters);
  if(is_array($parameters) && count($parameters) > 0){
    foreach ($parameters as $key => $value) {
      $query->bindValue(($key + 1), $value);
      //echo "<br />".$key." - ".$value;
    }
  }
  $query->execute();
  
  if($query->rowCount()){
    // finalDialogue(1, "Usuário editado com sucesso.", null);   

  }else{
    finalDialogue(0, "Erro ao executar update sql. Por favor, tente novamente mais tarde.", null);    
  }
}


/*
  string  $table - table name on Database
  string  $where - Clause where complete to select on mysql, Opcional group by, order
  array   $parameters - only values, string to bindValue
          $pdo - var Connection

  return = array $returnValues
*/
function deleteSQL($table, $where, $parameters, $pdo){

  $querySQL = "DELETE FROM ".$table." ".$where." ";
  // print_r($querySQL);

  $query = $pdo->prepare($querySQL);
  // echo count($parameters);
  if(is_array($parameters) && count($parameters) > 0){
    foreach ($parameters as $key => $value) {
      $query->bindValue(($key + 1), $value);
      // echo "<br />".$key." - ".$value;
    }
  }
  $query->execute();
}

/*
  string  $table - table name on Database
  array   $columns - only values, fields to select SQL
  string  $where - Clause where complete to select on mysql, Opcional group by, order
  array   $parameters - only values, string to bindValue
          $pdo - var Connection

  return = array $returnValues
*/
function selectSQL($table, $columns, $where, $parameters, $pdo){

  $querySQL = "SELECT ".implode(", ", $columns)." FROM ".$table." ".$where." ";
  //print_r($querySQL);

  $query = $pdo->prepare($querySQL);
  //echo count($parameters);
  if(is_array($parameters) && count($parameters) > 0){
    foreach ($parameters as $key => $value) {
      $query->bindValue(($key + 1), $value);
      //echo "<br />".$key." - ".$value;
    }
  }
  $query->execute();
  $returnValues = $query->fetchAll();

  return $returnValues;
}


/*
  string  $table - table name on Database
  array   $idColumn - idColumn from table SQL
  string  $where - Clause where complete to select on mysql, Opcional group by, order
  array   $parameters - only values, string to bindValue
  number  $pageNumberGet - only number, number to page active
  number  $quantityPerPage - only number, number the quantity to show on page 
          $pdo - var Connection

  return = array FirstPage = paginationStart, ActualPage = paginationNow, LastPage = paginationEnd, sql limit = limitSQL
*/
function PaginationSelect($table, $idColumn, $where, $parameters, $pageNumberGet, $quantityPerPage, $pdo){
  
  if(isset($quantityPerPage) && is_numeric($quantityPerPage) && $quantityPerPage > 0){
    $pageLength =  $quantityPerPage;
  }else{
    $pageLength =  "12";
  }

  $numberStart = ($pageNumberGet * $pageLength) - $pageLength;
  $limitSQL = " LIMIT " . $numberStart . ", " . $pageLength . "";
  // exit(json_encode($limitSQL));

  $numberSQL = selectSQL($table, array("COUNT(".$idColumn.") AS total"), $where, $parameters, $pdo);
  if (isset($numberSQL[0][0]) && is_numeric($numberSQL[0][0]) && $numberSQL[0][0] > 0) { // Quantidade de linhas no SELECT
    $totalNumberSQL = $numberSQL[0][0];
  }

  $paginationEnd = (string) (ceil($totalNumberSQL / $pageLength));


  $arrayReturn = array('paginationStart' => '1',
                        'paginationNow' => $pageNumberGet,
                        'paginationEnd' => $paginationEnd,
                        'countSQL' => $totalNumberSQL,
                        'limitSQL' => $limitSQL);

  return $arrayReturn;
}


/*
  array   $json - all values
  string  $field - field name
*/
function checkStringNoNull($json, $field){
  if(isset($json[$field]) && $json[$field] <> ''){

  }else{
    finalDialogue(0, "Parâmetro Obrigatório ".$field." não foi enviado.", null);
  }
}


/*
  string  $email - email
  string  $where - Clause where complete to select on mysql, Opcional group by, order
          $pdo - var Connection
*/
function checkEmailExistsonDB($email, $where, $pdo){

  $table = "bvzfdagnfqepipz70gyw.users";
  $columns = array("COUNT(iduser) AS total");
  $where = "WHERE email = ? ". $where;
  $parameters = array($email);

  $rowSQL = selectSQL($table, $columns, $where, $parameters, $pdo);

  if($rowSQL[0]['total'] > 0){
    finalDialogue(0, "Já existe um usuário com este email", null);
  }
}

/*
  int     $id - Database, table users ID
  string  $email - Database, unique index
  bolean  $saveSession - 0 no save, 1 save

  return = string $encryptToken and save the token in session
*/
function createToken($id, $email, $saveSession, $md5){
  $encryptToken = $id.$md5.$email;
  $encryptToken = hash('sha256', $encryptToken);

  if($saveSession == 1){
    $_SESSION['token'] = $encryptToken;
  }

  return $encryptToken;
}

/*
  return = string $tokenLogin
*/
function checkTokenSession(){
  if(isset($_SESSION['token']) && $_SESSION['token'] <> ''){
    $tokenLoginSession = $_SESSION['token'];
    $tokenLogin = "";

    foreach (getallheaders() as $name => $value) {
      if($name == 'token'){
        $tokenLogin = $value;
      }
    }

    if($tokenLogin <> ""){
      if($tokenLogin == $tokenLoginSession){
        return $tokenLogin;

      }else{
        finalDialogue(0, "Token enviado diferente do esperado.", null);
      }
    }else{
      finalDialogue(0, "Token não enviado no header da requisição.", null);
    }
    
  }else{
    finalDialogue(0, "Token não existe. Faça o login novamente.", null);
  }
}


/*
  date    $dataRecebida - YYYY-MM-DD

  return = format DD/MM/YYYY
*/
function dataBR($dataRecebida){
  $strExplode = explode("-", $dataRecebida);
  return $strExplode[2]."/".$strExplode[1]."/".$strExplode[0];
}

?>
