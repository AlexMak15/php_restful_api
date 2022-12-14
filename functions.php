<?php
function getUsers ($pdo): void
{
    $result = $pdo->query("SELECT * FROM std");
    $usersList = [];
    while ($user = $result->fetch(PDO::FETCH_ASSOC)) {
        $usersList[] = $user;
    }
    echo json_encode($usersList);
}

function getUser ($pdo, $id): void
{
    $result = $pdo->query("SELECT * FROM std WHERE `id` = $id");

    $data_res = $result->rowCount();
    if ($data_res === 0) {
      http_response_code(404);
      $res = [
          "status" => false,
          "message" => "Post not found"
      ];
        echo json_encode($res);
    }else{
        $user = $result->fetch(PDO::FETCH_ASSOC);
        echo json_encode($user);
    }
}

function addPost($pdo, $data): void
{
  $name = $data['name'];
  $surname = $data['surname'];
  $sql = "INSERT INTO `std`(`name`,`surname`) VALUES (:name, :surname)";

  $stmt = $pdo->prepare($sql);
  $stmt->execute(['name'=>$name,'surname'=>$surname]);
  http_response_code(201);
  $res = [
      "status"=> true,
      "user_id"=> $pdo->lastInsertId()
  ];
  echo json_encode($res);
}

function updatePost($pdo, $data, $id): void
{
    $name = $data['name'];
    $surname = $data['surname'];
    $sql = "UPDATE std SET name= :name, surname= :surname  WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["name"=>$name,"surname"=>$surname,"id"=>$id]);
    http_response_code(200);
    $res = [
        "status"=> true,
        "message"=> "Post is updated"
    ];
    echo json_encode($res);
}

function deletePost($pdo, $id): void
{
    $sql = "DELETE FROM `std` WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["id"=>$id]);
    http_response_code(200);
    $res = [
        "status"=> true,
        "message"=> "Post is deleted"
    ];
    echo json_encode($res);
}

function clean($value): string
{
    $value = trim($value);
    $value = htmlspecialchars($value);
    return $value;
}

function validator_form($method): array
{

    $errors = [];
    foreach ($method as $key => $val){
        $val = clean($val);
        if(empty($val)){
            $errors[$key] = "You need type your $key!";
        }elseif(strlen($val) < 3 || strlen($val) > 20){
            $errors[$key] = "In field $key you need type more than 3 symbol and not more than 20 symbol!";
        }

    }

    return $errors;
}