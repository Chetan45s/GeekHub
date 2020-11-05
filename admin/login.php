<?php
    require_once('../includes/config.php');
    if($user->is_logged_in()){
        header('location:index.php');
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <?php

    if(isset($_POST['submit'])){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if($user->login($username,$password)){
            header('location: index.php');
            exit;
        }
        else{
            $message = '<p class="invalid">Invalid Username or Password</p>';
        }

    }
    if(isset($message)){
        echo $message;
    }


    ?>

    <form action="" method="POST" class="form">
    <label>Username</label>
    <input type="text" name="username" value="" required/>
    <br>
    <label>Password</label>
    <input type="password" name="password" value="" required/>
    <br>
    <label></label>
    <input type="submit" name="submit" value="SignIn" />

</body>
</html>

