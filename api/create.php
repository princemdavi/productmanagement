<?php

require("../dbconnect.php");

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


$method = $_SERVER['REQUEST_METHOD'];

if($method == 'POST'){

    $data = file_get_contents('php://input');

    $_data = json_decode($data, true);
    
    $managerId = @$_data['managerId'];
    $productName = @$_data['productName'];
    $productQuantity = @$_data['productQuantity'];
    $productPrice = @$_data['productPrice'];

    if(empty($managerId) || empty($productName) || empty($productQuantity) || empty($productPrice)){

        http_response_code(400);

        echo json_encode(array("message"=>"Please provide all the required information (managerId, productName, productQuantity, productPrice)"));

        exit();
    }

    
    $select = $pdo->prepare("SELECT * FROM managers WHERE managerId = :managerId");
    $select->bindParam(':managerId', $managerId);
    $select->execute();

    if(!($select->rowCount() > 0)){
        http_response_code(401);

        echo json_encode(['message'=>'The manager id provided does not exist']);

    }else{

        try {

            $insert = $pdo->prepare("INSERT INTO products (managerId, productName, productPrice, productQuantity) VALUES (:managerId, :productName, :productPrice, :productQuantity)");

            $insert->bindParam(':managerId', $managerId);
            $insert->bindParam(':productName', $productName);
            $insert->bindParam(':productPrice', $productPrice);
            $insert->bindParam(':productQuantity', $productQuantity);

            $pdo->beginTransaction();

            $insert->execute();

            $lastInsertId = $pdo->lastInsertId();

            $pdo->commit();

            $select = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $select->bindParam(':id', $lastInsertId);
            $select->execute();

            $createdProduct = $select->fetch(PDO::FETCH_OBJ);

            $product_arr = array();


            $product_item = array("managerId"=>$createdProduct->managerId,"id"=>$createdProduct->id, "productName"=>$createdProduct->productName, "productPrice"=>$createdProduct->productPrice, "productQuantity"=>$createdProduct->productQuantity);

            $product_arr['product'] = $product_item;

            echo json_encode($product_arr);

        } catch (PDOException $e) {

            $pdo->rollBack();
            echo "Error: " . $e->getMessage();

        }

    }
    
}