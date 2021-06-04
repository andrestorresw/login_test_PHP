<?php
session_start(); 

// Snippet from https://stackoverflow.com/questions/1545357/how-can-i-check-if-a-user-is-logged-in-in-php
// Modified
if( $_SESSION["loggedin"] !== true && !isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/bootstrap.css" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap-utilities.css.map" type="text/css">
    <link rel="stylesheet" href="/css/bootstrap.css.map" type="text/css" >
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/popper.min.js"></script>


    <title>Welcome</title>
</head>
<body>
    <div class= "container text-center">
        <p> <?php echo " Hola: ", $_SESSION["username"], " Bienvenido de nuevo"; ?></p>

        <a href="logout.php" class="btn">Close Session</a>
        <br><br>
        <a href="change-password.php">Change Password</a>

    </div>
</body>
</html>