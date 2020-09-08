<?php
$dbhost = "localhost";
$dbname = "web_app";
$dbusername = "root";
$dbpassword = "fr3shk4b4y1";
$pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

function checkPOST($name , $placeholder = 0){
  if(isset($name)) {
    return $name;
  }
  else {
    return $placeholder;
  }
}

function getItemValues($arr , $index) {
    $exploded = explode("." , $arr);
    $newArr = array();
    for($i = 0; $i<=count($exploded);$i++) {
      array_push($newArr , $exploded[$i]);
    }
    $splitArr = explode("=" ,  $newArr[$index]);
    return  $splitArr[1];
}

function insertQuery($queryString , $arrayOfValues) {
global $pdo;
$statement = $pdo->prepare($queryString);
$statement->execute($arrayOfValues);
}

function getData($queryString , $whereValues = "" , $getSingleData = False) {

    global $pdo;

    $stmt = $pdo->prepare($queryString);

    if($whereValues == "") {
        $rowData = $stmt->execute();
        }
    else {
        $rowData = $stmt->execute($whereValues);
        }

        if($getSingleData == True) {
          $rows = $stmt->fetch();
        }
        else {
          $rows = $stmt->fetchAll();

        }
    return $rows;
}

function getRowCount($queryString , $whereValues = "") {

    global $pdo;

    $stmt = $pdo->prepare($queryString);

    if($whereValues == "") {
        $rowData = $stmt->execute();
        }
    else {
        $rowData = $stmt->execute($whereValues);
        }

    $rows = $stmt->rowCount();

    return $rows;
}
?>
