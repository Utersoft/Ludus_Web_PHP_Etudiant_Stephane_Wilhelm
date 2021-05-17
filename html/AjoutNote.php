<?php
    session_start();
    //Oouverture de la base de donnée
    try{
        $databaseStudents = new PDO('mysql:host=localhost;dbname=students', 'root');
        $databaseStudents->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    catch(exception $e){
        die('ERROR : '.$e->getMessage());
    }

    $sql = ('select pseudo, Nom, Prenom from Utilisateurs where EstProf = 0');
    $result = $databaseStudents->query($sql);
    
    $sql2 = $databaseStudents->prepare('insert into releveNote value (?, ?, ?, ?, ?)');
    $sql3 = $databaseStudents->prepare('insert into controle value (?, ?)');
    $sql4 = $databaseStudents->prepare('select evaluation from controle where evaluation = ?');

    if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $sql4->execute(array($_POST['Evaluation']));
        $result2 = $sql4->fetchAll();
        
        //On vérifie que l'évaluation n'existe pas déjà puisqu'il s'agit de la clef primaire de la table controle
        if ($result2[0]['evaluation'] == $_POST['Evaluation']){
            $errors = "Ce nom d'évaluation existe déjà.";
        }else{
            //Sinon, on enregistre les données dans les tables correspondantes
            $sql3->execute(array( $_POST["Evaluation"], $_POST["Matiere"]));
            foreach($result as $row){
                $sql2->execute(array($row['pseudo'], $_POST["Evaluation"], $_POST["Matiere"], $_POST["note".$row['pseudo']], $_POST["remarque".$row["pseudo"]]));
            }
        
            header('location:Accueil.php');
        }
        
    }


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/AjoutNote.css">
        <title>Ajout note</title>
    </head>
    <body>
        <div>
            <a href="Accueil.php">Accueil</a>
        </div>
        <div>
            <p>Veuillez choisir la matière dans laquelle vous souhaitez entrer la note.</p>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <input type="radio" id="Web" name="Matiere" value="Web" required>
                <label for="Web">Web</label>
                <br>
                <input type="radio" id="C/C++" name="Matiere" value="C/C++">
                <label for="C/C++">C/C++</label>
                <br>
                <input type="radio" id="GameDesign" name="Matiere" value="Game Design">
                <label for="GameDesign">Game Design</label>
                <br>
                <p>Veuillez entrer le nom de l'évaluation.</p>
                <input type="text" name="Evaluation" placeholder="Nom de l'évaluation" required>
                <p style="color:red;"><?php if(isset($errors)){
                    echo $errors;
                } ?></p>
                <br>
                <p>Veuillez entrer une note entre 0 et 20, ainsi qu'une remarque (la remarque est optionnelle).</p>
                <?php
                //Boucle de création du formulaire, plus particulièrement des notes de chaque élèves et leurs remarques
                    foreach($result as $row){
                        echo $row["pseudo"]." ".$row["Nom"]." ".$row["Prenom"]." : ";
                        echo "<input type='number' min='0' max='20' placeholder='note' name='note".$row['pseudo']."'>";
                        echo " Remarque : <textarea name='remarque".$row['pseudo']."' rows='5' cols='33' maxlength='100'></textarea>";
                        echo "<br>";
                    }
                ?>
                <input type="submit" value="Envoyer">
            </form>
        </div>
    </body>
</html>