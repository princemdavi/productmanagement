<?php

$error = $_SERVER['REDIRECT_STATUS'];

$error_title = "";
$error_message = "";

if ($error == 404){

    $error_title = "404 Page Not Found";
    $error_message = "The document/file requested was not found on this server";

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 page not found</title>
    <style>

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            background-color: #031438;
			color: #E3F1F3;
            display: flex;
            justify-content: center;
            align-items: center;
			flex-direction: column;
			min-height: 60vh;
			gap: 2rem;
        }

    </style>
</head>
<body>
    <h3><?php echo @$error_title ?></h3>
    <h5><?php echo @$error_message ?></h5>
</body>
</html>
