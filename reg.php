<?php

require_once 'databaseconnect.php';
require_once 'functions.php';


header('Content-type: json/application');

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = $params[1];

if($method === 'GET'){
    if($type === 'users'){
        if(isset($id)){
            getUser($pdo, $id);
        }else{
            getUsers($pdo);
        }
    }
}elseif ($method === 'POST'){

    if($type === 'users'){
        addPost($pdo,$_POST);

    }
}elseif ($method === 'PATCH'){
    if($type === 'users'){
        if(isset($id)){
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            updatePost($pdo,$data, $id);
        }
    }
}elseif ($method === 'DELETE'){
    if($type === 'users'){
      if(isset($id)){
          deletePost($pdo,$id);
      }
    }
}


