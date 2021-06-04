<?php
session_start(); 
// Snippet from https://stackoverflow.com/questions/1545357/how-can-i-check-if-a-user-is-logged-in-in-php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, `password` FROM users WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_username);
            
            $param_username = $username;
            
            if($stmt->execute()){
                $stmt->store_result();
                
                if($stmt->num_rows == 1){                    
    
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            session_start();

                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            header("location: welcome.php");

                        }                                                
                    }
                }
                
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
    <title>Login</title>
</head>
<body>
    <div>
        <h1>Inicio Sesion</h1>
        <p>Bienvenido por favor proporciona tus datos</p>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            

            <div>
                <p>Username: </p>
                <input type="text" name="username">

                <p>Password: </p>
                <input type="password" name="password">
                
                <br></br>

                <input type="submit" value="Submit">
                
                <p> <a href="register.php"> Crear cuenta </a></p>
            </div>
            
        </form>
    </div>
</body>
</html>