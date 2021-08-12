<?php include("./includes/header.php") ?>
    
<div class="container-login">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">

        <div class="header">
            <h1>Login</h1>
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="" class="form-control">
        </div>

        <button type="submit" class="btn" name="register">Login</button>

    </form>
</div>

<?php include("./includes/footer.php") ?>
