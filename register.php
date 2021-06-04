<?php

require_once "config.php";

$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["username"]))){
        $username_err = "Ingresa un usuario";
    } else{
        // Snippet from https://stackoverflow.com/questions/38928096/select-id-and-matching-username-order
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("s", $param_username);

            $param_username = trim($_POST["username"]);
            
            if($stmt->execute()){
                $stmt->store_result();
                
                // Taked form https://stackoverflow.com/questions/14741280/mysqli-stmt-num-rows-returning-0
                if($stmt->num_rows == 1){
                    $username_err = "Este usuario no está disponible";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Mmmm...Algo salió mal";
            }

            // Close statement
            $stmt->close();
        }
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Introduce una contraseña";
    } else{
        $password = trim($_POST["password"]);
    }
    
    if(empty($username_err) && empty($password_err)){
        
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            if($stmt->execute()){
                header("location: login.php");
            } else{
                echo "Mmmm...Algo salió mal";
            }

            $stmt->close();
        }
    }
    
    // Close connection
    $conn->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/bootstrap-5.0.1-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="/bootstrap-5.0.1-dist/js/bootstrap.min.js"></script>
    <title>Register</title>
</head>
<body>
    <div>

        <h1>Registrarse</h1>
        <p>Llena el formulario para registrarte</p>
        <br>
        <!--Used htmlspecialchars documentation 
        https://www.w3schools.com/php/func_string_htmlspecialchars.asp -->

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="container">
                <p>Username</p>
                <input type="text" name="username">
            </div>
            <div>
                <p>Password</p>
                <input type="password" name="password">
            </div>

            <br></br>
            <input type="submit" value="Submit">
        </form>
    </div>    
</body>
</html>