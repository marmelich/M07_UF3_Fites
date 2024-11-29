<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login parametres preparats y contrassenya encriptació sha2</title>
</head>
<body>
    <form method="POST">
        <label for="user">User: </label>
        <input type="text" name="user"/>
        <label for="password">Password: </label>
        <input type="password" name="password"/>
        <input type="submit" value="Enter"/>
    </form>



    <?php

        if ($_SERVER['REQUEST_METHOD']=='POST'){
            
            $user = $_POST["user"];
            $password = $_POST["password"];


            try {
                $hostname = "localhost";
                $dbname = "usuariosContrasenyas";
                $username = "admin";
                $pw = "macarrones con queso";
                $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
            } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
                exit;
            }
        
            //!!!!!!!! ENTRAR con usuario1 contrasena1
            try {
                //CONSULTA con parametros preparados y con encriptacion sha2 de 256bytes
                $query = $pdo->prepare("SELECT nombre_usuario, contrasena_usuario
                                                FROM usuarios
                                                WHERE nombre_usuario = :user and contrasena_usuario = sha2(:password,256);");
                $query->bindParam(":user", $user);
                $query->bindParam(":password", $password);
                $query->execute();

            } catch (PDOException $e) {
                echo "Error de SQL<br>\n";
                //comprovo errors:
                $e = $query->errorInfo();
                if ($e[0]!='00000') {
                echo "\nPDO::errorInfo():\n";
                die("Error accedint a dades: " . $e[2]);
                }  
            }

            
            $row = $query->fetch();
            if ( $row ) {
                echo "<p>Te damos la bienvenida, ".$row['nombre_usuario']."</p>";
                $row = $query->fetch();
            }
            else{
                echo "<p>Login incorrecte </p>";
            }
            
        }
    

    
    
    ?>

    
</body>
</html>