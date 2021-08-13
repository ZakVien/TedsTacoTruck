<?php
$dsn="mysql:host=localhost;dbname=pplwytue_tttt";
$username="pplwytue_tttt";
$password="tedstacos";

try{
    $db=new PDO($dsn, $username, $password);
}catch(Exception $e){
    $error = $e->getMessage();
    echo $error;
    exit();    
}
?>
