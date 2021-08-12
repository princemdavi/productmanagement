<?php include("./includes/header.php") ?>


<div class="container-contact">
    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <h1 class="header">Send us an email</h1>

        <div class="form-group">
            <label for="fullname">Fullname</label>
            <input type="text" name="fullname" placeholder="Enter your name" id="fullname" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="text" name="email" placeholder="Enter your email" id="email" class="form-control">
        </div>

        <button type="submit" class="btn" name="send">send message</button>
    </form>
</div>


<?php include("./includes/footer.php")  ?>