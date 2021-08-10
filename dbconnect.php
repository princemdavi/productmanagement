<?php

try {
    
    $pdo = new PDO('mysql:host=localhost;dbname=product_management','root','');

} catch (PDOException $e) {
    echo "";
}