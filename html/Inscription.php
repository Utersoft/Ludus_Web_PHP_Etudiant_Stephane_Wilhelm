<?php
    try{
        $databaseStudents = new PDO('mysql:host=localhost;dbname=students', 'root');
        $databaseStudents->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    catch(exception $e){
        die('ERROR : '.$e->getMessage());
    }
    
    $sql = $databaseStudents->prepare('INSERT INTO Utilisateurs VALUES (?, ?, ?, ?, ?, ?, ?)');
    
    $pseudo = $password = $passwordConfirmation = $firstName = $lastName = $mail = $phone = "";
    $prof = 0;
    $errors = array();
    $matiere = array('Web', 'C/C++', 'Game Design');
    
    //Vérifie si le boutton avec la méthode post a été cliqué
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $pseudo = $_POST["pseudo"];
        $password = $_POST["password"];
        $passwordConfirmation = $_POST["passwordConfirmation"];
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $mail = $_POST["mail"];
        $phone = $_POST["phone"];
        if (isset($_POST["prof"])){
            $prof = 1;
        }
    }
    
    $testMdp = FALSE;
    
    //On vérifie que les deux mots de passe soient identiques
    if ($password == $passwordConfirmation){
        $testMdp = TRUE;
    }


    //Si aucun des champs n'est vide alors il execute la suite
    if ($pseudo != "" and $firstName != "" and $lastName != "" and $mail != "" and $testMdp == TRUE){
        $sql2 = "SELECT pseudo, Email FROM Utilisateurs WHERE pseudo=? OR Email=? LIMIT 1";
        $query = $databaseStudents->prepare($sql2);
        $query->execute(array($pseudo, $mail));
        $result = $query->fetchAll();
        
        //On enregistre les erreurs dans un tableau d'erreur
        if ($result){
            if ($result[0]['pseudo'] === $pseudo){
                array_push($errors, "Le pseudo est déjà pris.");
            }
        
            if ($result[0]['Email'] === $mail){
                array_push($errors, "Cette adresse est déjà enregistrée.");
            }
        }
        
        //S'il n'y a pas d'erreur, on enregistre les données dans la base de donnée
        if (count($errors) == 0){
            $sql->execute(array($pseudo, $password, $firstName, $lastName, $mail, $phone, $prof));
            
            header('location: Merci.php');
        }
    }
    
    

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="/css/Inscription.css" rel="stylesheet">
        <title>Inscription</title>
        <script //type="text/javascript" src="/JS/Log_in.js"></script>
    </head>
    <body>
        <header>
            
            
        </header>
        <div>
            <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                <label for="pseudo">Pseudo : <bold style="color: red;">*</bold></label>
                <br>
                <input type="text" required name="pseudo" id="pseudo">
                <br>
                <label for="password">Mot de passe : <bold style="color: red;">*</bold></label>
                <br>
                <input type="password" required name="password" id="password">
                <br>
                <label for="passwordConfirmation">Confirmation du mot de passe : <bold style="color: red;">*</bold></label>
                <br>
                <input type="password" required name="passwordConfirmation" id="passwordConfirmation">
                <?php
                    if ($password != $passwordConfirmation){
                        echo '<p style="color:red;">Les deux mots de passe doivent être le même!</p>';
                    }
                ?> 
                <br>
                <label for="firstname">Prénom : <bold style="color: red;">*</bold></label>
                <br>
                <input type="text" required name="firstname" id="firstname">
                <br>
                <label for="lastname">Nom : <bold style="color: red;">*</bold></label>
                <br>
                <input type="text" required name="lastname" id="lastname">
                <br>
                <label for="mail">Email : <bold style="color: red;">*</bold></label>
                <br>
                <input type="email" required name="mail" id="mail">
                <br>
                <label for="phone">Téléphone : </label>
                <br>
                <input type="tel" name="phone" id="phone">
                <br>
                <label for="prof">Êtes-vous un professeur? </label>
                <input type="checkbox" name="prof" id="prof">
                <br>
                <input type="submit" value="S'inscrire" name="Confirmation">
                <?php  if (count($errors) > 0) : ?>
                    <div class="error">
                        <?php foreach ($errors as $error) : ?>
                            <p style="color:red;"><?php echo $error ?></p>
                        <?php endforeach ?>
                    </div>
                <?php  endif ?>
                <br>
                <p>Déjà inscrit? <a href="../Index.php">Se connecter</a></p>
            </form>
        </div>
    </body>
</html>