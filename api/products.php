<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization");

require("../dbconnect.php");


$select = $pdo->prepare("SELECT * FROM products");
$select->execute();


$page = $_GET['page'] ?? 1;
$post_per_page = 2;
$number_of_pages = ceil($select->rowCount() / $post_per_page);

if($page < 1) $page = 1;

if($page > $number_of_pages) $page = $number_of_pages;


$offset = ($page * $post_per_page) - $post_per_page;

$select = $pdo->prepare("SELECT * FROM products LIMIT $offset, $post_per_page");
$select->execute();

$products = $select->fetchAll(PDO::FETCH_ASSOC);

$products_arr = array();

$products_arr['page'] = "$page of $number_of_pages";

if($select->rowCount() > 0){

    $products_arr['data'] = array();

    foreach($products as $product){

        extract($product);

        $product_item = array(
            "productId"=>$id,
            "productName"=>$productName,
            "productQuantity"=>$productQuantity,
            "productPrice"=>$productPrice,
        );

        array_push($products_arr['data'], $product_item);

    }

}

http_response_code(200);
echo json_encode($products_arr);