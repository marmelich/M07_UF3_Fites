<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita 3.1</title>
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
        <h2>Filtre per número d'habitants</h2>
        <label for="minim">Mínim: </label>
        <input type="number" name="minim"/>
        </br>
        <label for="maxim">Màxim: </label>
        <input type="number" name="maxim"/>
        </br>
        <input type="submit"/>
    </form>
    </br>
    </br>


    <?php
        $minim = $_POST["minim"];
        $maxim = $_POST["maxim"];

 		# (1.1) Connectem a MySQL (host,usuari,contrassenya)
 		$conn = mysqli_connect('localhost','admin','macarrones con queso');
 
 		# (1.2) Triem la base de dades amb la que treballarem
 		mysqli_select_db($conn, 'mundo');
 
 		# (2.1) creem el string de la consulta (query)
 		$consulta = "SELECT * FROM city WHERE population BETWEEN $minim and $maxim ORDER BY population desc;";
 
 		# (2.2) enviem la query al SGBD per obtenir el resultat
 		$resultat = mysqli_query($conn, $consulta);
 
 		# (2.3) si no hi ha resultat (0 files o bé hi ha algun error a la sintaxi)
 		#     posem un missatge d'error i acabem (die) l'execució de la pàgina web
 		if (!$resultat) {
     			$message  = 'Consulta invàlida: ' . mysqli_error($conn) . "\n";
     			$message .= 'Consulta realitzada: ' . $consulta;
     			die($message);
 		}
    ?>

    <!-- (3.1) aquí va la taula HTML que omplirem amb dades de la BBDD -->
    <table>
    <!-- la capçalera de la taula l'hem de fer nosaltres -->
    <thead>
    <th colspan="4" align="center" bgcolor="cyan">Llistat de ciutats</th>
    </thead>

    <?php
        # (3.2) Bucle while
        while( $registre = mysqli_fetch_assoc($resultat) )
        {
            # els \t (tabulador) i els \n (salt de línia) son perquè el codi font quedi llegible
            # (3.3) obrim fila de la taula HTML amb <tr>
            echo "\t<tr>\n";

            # (3.4) cadascuna de les columnes ha d'anar precedida d'un <td>
            #	després concatenar el contingut del camp del registre
            #	i tancar amb un </td>
            echo "\t\t<td>".$registre["Name"]."</td>\n";
            echo "\t\t<td>".$registre['CountryCode']."</td>\n";
            echo "\t\t<td>".$registre["District"]."</td>\n";
            echo "\t\t<td>".$registre['Population']."</td>\n";

            # (3.5) tanquem la fila
            echo "\t</tr>\n";
        }
    ?>
    <!-- (3.6) tanquem la taula -->
    </table>	


    
</body>
</html>