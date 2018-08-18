<?php


//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Req includes
include_once '../config/database.php';
include_once '../objects/Donation.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$product = new Donation($db);

//Get post data
$data = json_decode(file_get_contents("php://input"));

//set Id and values of product to be edited
$product->from_cusID      = $data->from_cusID;
$product->To_cusID        = $data->To_cusID;
$product->location        = $data->location;
$product->status          = $data->status;
$product->type_id         = $data->type_id;
$product->amount          = $data->amount;
$product->image           = $data->image;
$product->donationID      = $data->donationID;
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
