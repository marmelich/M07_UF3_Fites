<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita 3.2</title>
    <style>
 		body{
 		}
 		table,td {
 			border: 1px solid black;
 			border-spacing: 0px;
 		}
 	</style>
</head>
<body>
    
    <form method="POST">
        <h2>Filtre per llengua</h2>
        <label for="llengua">Llengua: </label>
        <input type="text" name="llengua"/>
        </br>
        <input type="submit"/>
    </form>
    </br>
    </br>

    <?php
     if ($_SERVER['REQUEST_METHOD']=='POST'){
        $llengua = $_POST["llengua"];

        # (1.1) Connectem a MySQL (host,usuari,contrassenya)
        $conn = mysqli_connect('localhost','admin','macarrones con queso');

        # (1.2) Triem la base de dades amb la que treballarem
        mysqli_select_db($conn, 'mundo');

        # (2.1) creem el string de la consulta (query)
        $consulta = "SELECT DISTINCT language, isOfficial FROM countrylanguage WHERE language LIKE '%$llengua%';";

        # (2.2) enviem la query al SGBD per obtenir el resultat
        $resultat = mysqli_query($conn, $consulta);

        # (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
        #     posem un missatge d'error i acabem (die) l'execució de la pàgina web
        if (!$resultat) {
                $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
                $message .= 'Consulta realitzada: ' . $consulta;
                die($message);
        }
       echo "<ul>";
       # (3.2) Bucle while
       while( $registre = mysqli_fetch_assoc($resultat) ){
           if ($registre['isOfficial']=="T"){
               echo "<li>".$registre["language"]."[OFICIAL]</li>";
           }
           else{
               echo "<li>".$registre["language"]."</li>";
           }
       }
       echo "</ul>";

     }
        
    ?>



</body>
</html>