<?php

session_start();
require("./dbconnect.php");

if(empty($_SESSION['name'] || $_SESSION['managerId'])){
    header("Location: login");
}

$name = $_SESSION['name'];
$managerId = $_SESSION['managerId'];

$stmt = $pdo->prepare("SELECT * FROM products WHERE managerId = :managerId ORDER BY createdAt DESC");
$stmt->bindParam(':managerId', $managerId);
$stmt->execute();;

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$no = 1;

//! deleting a product

if(isset($_POST['delete']) && !empty($_POST['delete'])){
 
    $productId = $_POST['delete'];

    $delete = $pdo->prepare("DELETE FROM products WHERE id = :productId");
    $delete->bindParam(':productId', $productId);
    $delete->execute();

    if($delete->rowCount() > 0){
        header("Location: dashboard");
    }
}


//! updating an existing product

if(isset($_POST['edit']) && !empty($_POST['productId'] && $_POST['productName'] && $_POST['productQuantity'] && $_POST['productPrice'])){
 
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productQuantity = $_POST['productQuantity'];
    $productPrice = $_POST['productPrice'];

    $update = $pdo->prepare("UPDATE products SET productName = :productName, productQuantity = :productQuantity, productPrice = :productPrice WHERE id = :productId");

    $update->bindParam(':productName', $productName);
    $update->bindParam(':productQuantity', $productQuantity);
    $update->bindParam(':productPrice', $productPrice);
    $update->bindParam(':productId', $productId);
    $update->execute();

    header("Location: dashboard");

}


//! adding a new product
if(isset($_POST['add']) && !empty($_POST['productName'] && $_POST['productQuantity'] && $_POST['productPrice'] && $managerId)){
 
    $productName = $_POST['productName'];
    $productQuantity = $_POST['productQuantity'];
    $productPrice = $_POST['productPrice'];

    $insert = $pdo->prepare("INSERT INTO products (managerId, productName, productQuantity, productPrice) VALUES (:managerId, :productName, :productQuantity, :productPrice)");

    $insert->bindParam(':productName', $productName);
    $insert->bindParam(':managerId', $managerId);
    $insert->bindParam(':productName', $productName);
    $insert->bindParam(':productQuantity', $productQuantity);
    $insert->bindParam(':productPrice', $productPrice);
    $insert->execute();

    header("Location: dashboard");

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dashboard.css">
    <link rel="stylesheet" href="./css/footer.css">
    <title>Dashboard</title>
</head>
<body>
        <header>
            <div class="container container-nav">
                <h1>welcome <?php echo @$name ?></h1>
                <button class="btn-logout" onclick="logout()">log out</button>
            </div>
        </header>
        <div class="container">
            <div class="table-wrapper">
                <table border="1" class="table">
                    <button class="add__product" onclick="openAddProductForm()">ADD NEW PRODUCT</button>
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>PRODUCT NAME</th>
                            <th>PRODUCT QUANTITY</th>
                            <th>PRODUCT PRICE</th>
                            <th>EDIT</th>
                            <th>DELETE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($products) > 0): ?>

                            <?php foreach($products as $product): ?>
                                <tr>
                                    <td>
                                        <?php echo $no++; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['productName']; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['productQuantity']; ?>
                                    </td>
                                    <td>
                                        <?php echo $product['productPrice']; ?>
                                    </td>
                                    <td>
    
                                        <button 
    
                                            data-product_id="<?php echo $product['id']; ?>" 
                                            data-product_name="<?php echo $product['productName']; ?>" 
                                            data-product_quantity="<?php echo $product['productQuantity']; ?>" 
                                            data-product_price="<?php echo $product['productPrice']; ?>"
                                            onclick="editProduct(this)" class="btn-edit">Edit
    
                                        </button>
    
                                    </td>
                                    <td>
                                        <form action="" method="post" onsubmit="return deleteProduct()">
                                            <button type="submit" value="<?php echo $product['id']; ?>" name="delete" >Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <tr>
                                <td colspan="6" style="text-align: center; font-weight: bolder; font-size: .75rem; color: green">
                                    <p style="margin-bottom: 1rem;">You don't have any products to manage</p>
                                    <p>You can add new products to manage using the add new product button above</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="form-wrapper edit" hidden>
                <h1>Edit product</h1>
                <form action="" method="post" id="edit_product_form" onsubmit="closeEditProductForm()">
                    <input type="hidden" name="productId">
                    <div class="form-group">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" name="productName" id="productName" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="productQuantity" class="form-label">Quantity</label>
                        <input type="text" name="productQuantity" id="productQuantity" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="productPrice" class="form-label">Product Price</label>
                        <input type="text" name="productPrice" id="productPrice" class="form-control">
                    </div>
    
                    <div class="buttons">
                        <button type="submit" name="edit" class="btn-edit">Save</button> <button type="button" class="btn-edit btn-cancel" onclick="closeEditProductForm()">Cancel</button>
                    </div>
                </form>
            </div>

                <div class="form-wrapper add" hidden>
                    <h1>Add product</h1>
                    <form action="" method="post" id="edit_product_form" onsubmit="closeAddProductForm()">
                        <div class="form-group">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" name="productName" id="productName" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="productQuantity" class="form-label">Quantity</label>
                            <input type="text" name="productQuantity" id="productQuantity" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="productPrice" class="form-label">Product Price</label>
                            <input type="text" name="productPrice" id="productPrice" class="form-control">
                        </div>
        
                        <div class="buttons">
                            <button type="submit" name="add" class="btn-edit">Add</button> <button type="button" class="btn-edit btn-cancel" onclick="closeAddProductForm()">Cancel</button>
                        </div>
                    </form>
                </div>
        </div>


    <script>

        function logout(){
            window.location.assign("logout")
        }


        function deleteProduct(){

            if(confirm("Are you sure you want to delete this product? ")){
                return true
            }else{
                return false
            }
        }

            
        function openEditProductForm(){
            const editFormWrapper = document.querySelector(".edit")
            editFormWrapper.removeAttribute("hidden")

        }

        function closeEditProductForm(){
            const editFormWrapper = document.querySelector(".edit")
            editFormWrapper.setAttribute("hidden","hidden")
            window.scrollTo(0,0)
        }

        function openAddProductForm(){

            closeEditProductForm()

            const editFormWrapper = document.querySelector(".add")
            editFormWrapper.removeAttribute("hidden")

            let height = document.documentElement.offsetHeight
            let width = document.documentElement.offsetHeight

            window.scrollTo(width,height)

        }

        function closeAddProductForm(){
            const editFormWrapper = document.querySelector(".add")
            editFormWrapper.setAttribute("hidden","hidden")

            window.scrollTo(0,0)

        }


        function scrollToBottom(){
            let height = document.documentElement.offsetHeight
            let width = document.documentElement.offsetHeight

            window.scrollTo(width,height)
        }


        function editProduct(e){

            closeAddProductForm()
            openEditProductForm()

            scrollToBottom()

            var pId = document.querySelector("#edit_product_form")[0]
            var pName = document.querySelector("#edit_product_form")[1]
            var pQuantity = document.querySelector("#edit_product_form")[2]
            var pPrice = document.querySelector("#edit_product_form")[3]

            var productId = e.dataset.product_id
            var productName = e.dataset.product_name
            var productQuantity = e.dataset.product_quantity
            var productPrice = e.dataset.product_price

            pId.value = productId
            pName.value = productName
            pQuantity.value = productQuantity
            pPrice.value = productPrice
            
        }

    </script>
<?php include("./includes/footer.php") ?>