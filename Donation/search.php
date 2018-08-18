<?php


//Req headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset:UTF-8");

//Req includes
include_once '../config/database.php';
include_once '../objects/donation.php';

//Db conn and instances
$database = new Database();
$db=$database->getConnection();

$product = new Donation($db);

//get keywords
$keywords = isset($_GET["s"]) ? $_GET["s"] : "";

//query products
$stmt=$product->search($keywords);
$num=$stmt->rowCount();

//check if more than 0 record found
if($num>0){

  //products array
    $products_arr = array();
    $products_arr["records"] = array();

    //retrieve table contents
    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $product_item = array(
            "from_cusID"          =>  $from_cusID,
            "To_cusID"            =>  $To_cusID,
            "location"            =>  $location,
            "status"              =>  $status,
            "type_id"             =>  $type_id,
            "amount"             =>  $amount,
            "timestamp"           => $timestamp,
            "image"               =>$image

        );


        array_push($products_arr["records"], $product_item);
    }

    echo json_encode($products_arr);
}else{
    echo json_encode(
        array("message" => "No products found.")
    );
}
