<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fita 5.2</title>
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
        <h2>Busca per país:</h2>
        <label for="pais">País: </label>
        <input type="text" name="pais"/>
        <input type="submit"/>
    </form>
    </br>
    </br>


    <?php

        if ($_SERVER['REQUEST_METHOD']=='POST'){
            
            $pais = $_POST["pais"];
            echo "<h1>Cities from " . $pais . "</h1>";


            try {
                $hostname = "localhost";
                $dbname = "mundo";
                $username = "admin";
                $pw = "macarrones con queso";
                $pdo = new PDO("mysql:host=$hostname;dbname=$dbname", "$username", "$pw");
            } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
                exit;
            }
        
        
            try {
                //preparem i executem la consulta
                $query = $pdo->prepare("SELECT co.Name as coName, la.Language as laLanguage, la.IsOfficial as laIsOfficial, la.Percentage as laPercentage
                                        FROM country co 
                                        JOIN countrylanguage la
                                        ON co.code = la.CountryCode 
                                        WHERE co.Name LIKE '%$pais%';");
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


            echo "<ul>";
             $row = $query->fetch();
            while ( $row ) {
                echo "<li>".$row['coName']." || ".$row['laLanguage']." || Official: ".$row['laIsOfficial']." || ".$row['laPercentage']."%</li>";
                $row = $query->fetch();
            }
            echo "</ul>";
            
        }
    

    
    
    ?>



</body>
</html>