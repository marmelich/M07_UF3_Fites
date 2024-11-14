<?php
# (1.1) Connectem a MySQL (host,usuari,contrassenya)
$conn = mysqli_connect('localhost','admin','macarrones con queso');
 
# (1.2) Triem la base de dades amb la que treballarem
mysqli_select_db($conn, 'mundo');

# (2.1) creem el string de la consulta (query)
$consulta = "SELECT Continent from country group by Continent;";


# (2.2) enviem la query al SGBD per obtenir el resultat
$resultat = mysqli_query($conn, $consulta);

# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
if (!$resultat) {
        $message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
        $message .= 'Consulta realitzada: ' . $consulta;
        die($message);
}

$continents = [];
// Extraer los datos fila por fila
while ($fila = mysqli_fetch_assoc($resultat)) {
    $continents[] = $fila['Continent']; 
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita 4.1</title>
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
    <select id="continent" name="continent">
        <?php
        for ($i = 0; $i<sizeof($continents); $i++){
            echo "<option value='$continents[$i]'>$continents[$i]</option>";
        }
        ?>
    </select>
    <button type="submit">Tramet la consulta</button>
  </form>


    <?php
    if ($_SERVER['REQUEST_METHOD']=='POST'){
    
        $continent = $_POST["continent"];
        echo "<h1>Countries from " . $continent . "</h1>";

 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','macarrones con queso');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)
         $consulta = "SELECT Name FROM country WHERE Continent = '$continent' ;";
 
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
        while ($fila = mysqli_fetch_assoc($resultat)) {
            echo "<li>" . $fila['Name'] . "</li>";
        }
        echo "</ul>";
        
    }
    ?>


    
</body>
</html>