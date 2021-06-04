<?php
session_start();
 
// Snippet from https://stackoverflow.com/questions/1545357/how-can-i-check-if-a-user-is-logged-in-in-php
if( $_SESSION["loggedin"] !== true && !isset($_SESSION["loggedin"])){
    header("location: login.php");
    exit;
}

require_once "config.php";
 
$new_password = "";
$new_password_err = "";
 
// https://www.php.net/manual/es/reserved.variables.server.php
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Ingresa un valor";
    }else{
        $new_password = trim($_POST["new_password"]);
    }
    
    if(empty($new_password_err)){
        $sql = "UPDATE users SET `password` = ? WHERE id = ?";
        
        if($stmt = $conn->prepare($sql)){
            
            $stmt->bind_param("si", $param_password, $param_id);
            
            // Based on https://www.php.net/manual/es/function.password-hash.php
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            if($stmt->execute()){
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Mmm...Algo salió mal";
            }

            $stmt->close();
        }
    }
    $conn->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <div>
        <h2>Reset Password</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div>
                <p>New Password</p>
                <input type="password" name="new_password" class="<?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span> <?php echo $new_password_err; ?></span>
            </div>

            <br>

            <input type="submit" value="Submit">
        </form>
    </div>    
</body>
</html>