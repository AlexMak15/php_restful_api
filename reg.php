<?php

require_once 'databaseconnect.php';
require_once 'functions.php';


header('Content-type: json/application');

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = $params[1];


switch ($method){

    case 'GET':
        if($type === 'users'){
            if(isset($id)){
                getUser($pdo, $id);
            }else{
                getUsers($pdo);
            }
        }
        break;
    case 'POST':
        if($type === 'users'){
            if(validator_form($_POST)){
                $errors = validator_form($_POST);
                echo json_encode($errors);
            }else{
                addPost($pdo,$_POST);
            }





        }
        break;
    case 'PATCH':
        if($type === 'users'){
            if(isset($id)){
                $data = file_get_contents('php://input');
                $data = json_decode($data, true);
                if(validator_form($data)){
                    $errors = validator_form($data);
                    echo json_encode($errors);
                }else{
                    updatePost($pdo,$data, $id);
                }

            }
        }
        break;
    case 'DELETE':
        if($type === 'users'){
            if(isset($id)){
                deletePost($pdo,$id);
            }
        }
        break;

}
