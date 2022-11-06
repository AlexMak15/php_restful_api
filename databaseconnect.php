<?php
require_once "pdoconfig.php";

try{
    $pdo = new
      PDO("$driver:host=$host; dbname=$db_name; charset=$charset",
      $db_user, $db_pass, $option);
    }catch(PDOException $e){
        die("Ой лишенько!");
    
    }