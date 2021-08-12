<?php 

include("./includes/header.php");
require_once("./dbconnect.php");


if(isset($_POST['register'])){

    $name = trim($_POST['name']);
    $userName = trim($_POST['username']);
    $password = trim($_POST['password']);

    //! Error handling

    $errors = array("name"=>"", "username"=>"", "password"=>"");

    if(empty($name)){
        $errors['name'] = "This field is required";
    }else{

        if(strlen($name) < 3){
            $errors['name'] = "A name must have atleast 3 characters";
        }
    }

    if(empty($userName)){
        $errors['username'] = "This field is required";
    }else{

        if(strlen($userName) < 3){
            $errors['username'] = "A username must have atleast 3 characters";
        }
    }

    if(empty($password)){
        $errors['password'] = "This field is required";
    }else{

        if(strlen($password) < 5){
            $errors['password'] = "A password must have atleast 6 characters";
        }
    }

    //! end of error handling 

    $error = "";

    if(!array_filter($errors)){
        
        $select = $pdo->prepare("SELECT * FROM admins WHERE username=:username");
        $select->bindParam(':username', $userName);
        $select->execute();

        if($select->rowCount()){
            $error = "Username is already in use";
        }else{

            $hashedPass = password_hash($password, PASSWORD_DEFAULT);
            $insert = $pdo->prepare("INSERT INTO admins (name, username, password) VALUES (:name, :username, :password)");
            $insert->bindParam(':name', $name);
            $insert->bindParam(':username', $userName);
            $insert->bindParam(':password', $hashedPass);
            $insert->execute(); 

            if($insert->rowCount()){
                header("Location: login");
            }else{
                $error = "Something went wrong";
            }
        }
    }
}

?>

    
<div class="container-register">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="header">
            <h1>Register</h1>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="" class="form-control" value="<?php echo htmlspecialchars(@$name) ?>">
            <div class="error"><?php echo @$errors['name'] ?></div>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="" class="form-control" value="<?php echo htmlspecialchars(@$userName) ?>">
            <div class="error"><?php echo @$errors['username'] ?></div>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="" class="form-control">
            <div class="error"><?php echo @$errors['password'] ?></div>
        </div>

        <button type="submit" class="btn" name="register">Register</button>
        <div><?php echo @$error ?></div>
    </form>
</div>

<?php include("./includes/footer.php") ?>
