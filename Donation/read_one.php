<?php

//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: access");

//Include db and object

include_once '../config/database.php';
include_once '../objects/Product.php';

//New instances

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

//Set ID of product to be edited
$product->id = isset($_GET['id']) ? $_GET['id']: die;

//Read details of edited product
$product->readOne();


//Create array
$product_item = array(
    "cus_name"           =>  $cus_name,
    "cus_email"          =>  $cus_email,
    "cus_pw"             =>  $cus_pw,
    "roles"              =>  $roles,
);


print_r(json_encode($product_arr));
