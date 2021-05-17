<?php
    try{
        $databaseStudents = new PDO('mysql:host=localhost;dbname=students', 'root', '');
        $databaseStudents->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    
    catch(exception $e){
        die('ERROR : '.$e->getMessage());
    }
    
    $pseudo = "";
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="/css/Inscription.css" rel="stylesheet">
        <title>Merci</title>
    </head>
    <body>
        <header>
            
            
        </header>
        <div>
            <h1>Merci de vous être inscrit</h1>
            <p><a href="../Index.php">S'identifier</a></p>
        </div>
    </body>
</html>