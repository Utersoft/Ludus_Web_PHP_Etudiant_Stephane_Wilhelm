<?php
    session_start();
        
    $motDePasse = $login = "";
    $errors = array();
    
    //On appelle la base de donnée que l'on va utiliser pour les requêtes
    try{
        $databaseStudents = new PDO("mysql:host=localhost;dbname=students", "root", "");
        $databaseStudents->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }
    
    //On gère l'affichage des erreurs
    catch(exception $e){
        die('ERROR : '.$e->getMessage());
    }
    //On prépare des requêtes sql à executer plus tard
    $sql = $databaseStudents->prepare("select pseudo, MotDePasse from Utilisateurs where pseudo = ? and MotDePasse = ? limit 1;");
    $sql3 = $databaseStudents->prepare("select EstProf from Utilisateurs where pseudo = ?");
    
    //On vérifie qu'un bouton submit renvoyant des données avec la méthode post est en cours
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $motDePasse = $_POST["motDePasse"];
        $login = $_POST["login"];
    }
    
    //On check si le mot de passe et le login sont bons
    if ($login != "" and $motDePasse != ""){
    
        $sql->execute(array($login, $motDePasse));
        $result = $sql->fetchAll();

        //Si le resultat est mauvais on ajoute un message d'erreur dans le tableau des messages d'erreurs
        if (!$result){
            array_push($errors, "Le nom d'utilisateur ou le mot de passe est incorrect.");
        }
        
        //Si le tableau d'erreurs est vide, c'est qu'il n'y a pas d'erreur donc on continue
        if (count($errors) == 0){
            //On enregistre dans la session le login et le mdp, qui permmettront à l'utilisateur de rester connecter tant que la session est ouverte
            $_SESSION["login"] = $login;
            $_SESSION["MotDePasse"] = $motDePasse;
            
            //On execute une requête préparer en amont
            $sql3->execute(array($login));
            $result3 = $sql3->fetchAll();
            
            
            //On enregistre dans la session si l'utilisateur est un professeur
            if ($result3[0]["EstProf"] == 0 or $result3[0]["EstProf"] == NULL){
                $_SESSION["estProf"] = FALSE;
            }else{
                $_SESSION["estProf"] = TRUE;
            }
            
            //On envoit l'utilisateur à la page d'acceuil quand tout est bon
            header('location:html/Accueil.php');
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link href="/css/Log_in.css" rel="stylesheet">
        <title>Login</title>
        <script type="text/javascript" src="/JS/Log_in.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <?php
            //On check si l'utilisateur n'a pas déjà une session en cours
            if (!isset($_SESSION["login"])){
        ?>
            <header>
                <h1>Bienvenu utilisateur!</h1>
                <p>Veuillez vous identifier pour vous connecter.</p>
            </header>
            <div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div id="identification">
                        <input type="text" id="login" name="login" required placeholder="Login">
                        <br>
                        <input type="password" id="loginSpace" name="motDePasse"  required placeholder="Mot de passe" readonly>
                        <?php  if (count($errors) > 0) : ?>
                            <div class="error">
                                <?php foreach ($errors as $error) : ?>
                                    <p style="color:red;"><?php echo $error ?></p>
                                <?php endforeach 
                                    //On affiche la ou les erreurs enregistrées
                                ?>
                            </div>
                        <?php  endif ?>
                    </div>
                    <br>
                    <table>
                        <tr>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                        </tr>
                        <tr>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                        </tr>
                        <tr>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                        </tr>
                        <tr>
                            <td>   </td>
                            <td class="emplacement" onclick="codeNombre(this)"></td>
                            <td>   </td>
                        </tr>
                    </table>
                    <input id="effacer" type="button" onclick="effacerLogin()" value="Effacer">
                    <br>
                    <input type="submit" value="Connexion" name="Envoyer">
                    <p>Pas encore de compte? : <a href="html/Inscription">S'inscrire</a></p>
                </form>
                <script>
                    var n_tabNb = nbAleatoires([0,1,2,3,4,5,6,7,8,9]);
                    //On place les nombres aléatoires sur le cadre pour le mot de passe
                    $(".emplacement").each(function(i){
                        if(this.innerHTML === ""){
                            this.innerHTML = n_tabNb[i];
                        }
                    });

                
                </script>
            </div>
        <?php
            }else{
                //S'il est déjà connecté, on ne lui affiche pas le menu de connexion mais la possibilité de se déconnecter ou d'aller à l'accueil de sa page perso
                $sql2 = $databaseStudents->prepare('Select Pseudo, Prenom from Utilisateurs where Pseudo = ? limit 1');
                $sql2->execute(array($_SESSION["login"]));
                $result = $sql2->fetchAll();
        ?>
            <header>
                <h1><?php echo "Bonjour ".$result[0]['Prenom']."!" ?></h1>
            </header>
            <div>
                <a href="html/Accueil.php">Accueil</a>
            </div>
            <div>
                <a href="/html/Deconnexion.php">Déconnexion</a>
            </div>
        <?php
            }
        ?>
    </body>
</html>