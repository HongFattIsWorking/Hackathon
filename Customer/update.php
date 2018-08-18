<?php


//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/Customer.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$product = new Customer($db);

//Get post data
$data = json_decode(file_get_contents("php://input"));

//set Id and values of product to be edited
$product->customer_id   = $data->customer_id;
$product->cus_name      = $data->cus_name;
$product->cus_email     = $data->cus_email;
$product->cus_pw        = $data->cus_pw;
$product->roles         = $data->roles;

//update product
if($product->update()){
    echo '{';
        echo '"message": "Product was updated."';
    echo '}';
}else{
    echo '{';
        echo '"message": "Unable to update product."';
    echo '}';
}
