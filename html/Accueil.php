<?php
    session_start();
    try{
        $databaseStudents = new PDO('mysql:host=localhost;dbname=students', 'root');
        $databaseStudents->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }

    catch(exception $e){
        die('ERROR : '.$e->getMessage());
    }

    $sql = $databaseStudents->prepare('select Nom, Prenom from Utilisateurs where pseudo = ? limit 1');
    $sql->execute(array($_SESSION["login"]));
    $result = $sql->fetchAll();
    $sql6 = $databaseStudents->prepare('select count(Evaluation) as NbEvaluation from controle');
    $result6 = $sql->execute();
    $result6 = $result6[0]['NbEvaluation'];
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../css/Accueil.css">
        <title>Accueil</title>
    </head>
    <body>
        <?php //On check si l'utilisateur est un élève ou un prof
            if ($_SESSION["estProf"]){
                ?>
                <header>
                    <section>
                        <h1>Ecole Imaginaire Intranet</h1>
                        <nav>
                            <ul>
                                <li><a href="Accueil.php">Accueil</a></li>
                                <li><a href="AjoutEleve.php">Ajouter un élève</a></li>
                                <li><a href="AjoutNote.php">Ajouter des notes</a></li>
                                <li><a href="Deconnexion.php">Se déconnecter</a></li>
                            </ul>
                        </nav>
                    </section>
                </header>
                <div>
                    <h2><?php echo "Bonjour M(me) ".$result[0]["Prenom"]." ".$result[0]["Nom"]; ?></h2>
                </div>
                <div id="prof">
                    <table>
                        <thead>
                            <tr>
                                <td>Elèves</td>
                                <td>Matière</td>
                                <td>Evaluation</td>
                                <td>Note</td>
                                <td>Remarque</td>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        //On veut les élèves, les matières et leur notes/remarques
                        $sql2 = 'select releveNote.Pseudo, Nom, Prenom, releveNote.Matiere, releveNote.Evaluation, Note, Remarque from Utilisateurs, releveNote where Utilisateurs.pseudo = releveNote.pseudo order by Prenom, releveNote.Matiere';
                        $result2 = $databaseStudents->query($sql2);
                        //On veut récupérer la moyenne générale de chaque élève
                        $sql4 = $databaseStudents->prepare('select Nom, Prenom, round(avg(note),2) as moyenne from Utilisateurs, releveNote where Utilisateurs.pseudo = releveNote.pseudo and releveNote.pseudo = ? GROUP by NOM order by Prenom, releveNote.Matiere');
                            
                        $nom = $prenom = "";
                        //Affichage des élèments de la requête
                        foreach($result2 as $row){
                            echo "<tr>";
                            //On affiche le prénom à la première ligne de chaque élève et sa photo à  la 2ème
                            if ($nom != $row['Nom'] and $prenom != $row['Prenom']){
                                $sql4->execute(array($row['Pseudo']));
                                $result4 = $sql4->fetchAll();
                                echo "<td>".$row['Prenom']." ".$row['Nom']."</td><td></td><td>Moyenne de l'élève</td><td>".$result4[0]['moyenne']."</td><td></td>";
                                echo "</tr><tr class='first'>";
                                echo "<td class='vide' rowspan='".$result6."'><img src='../Images/".$row['Pseudo']."' width='110' height='100'></td>";
                              
                                echo "<td>".$row['Matiere']."</td><td>".$row['Evaluation']."</td><td>".$row["Note"]."</td><td>".$row["Remarque"]."</td>";
                                
                            }else{
                                echo "<td class='vide'></td>";
                              
                                echo "<td>".$row['Matiere']."</td><td>".$row['Evaluation']."</td><td>".$row["Note"]."</td><td>".$row["Remarque"]."</td>";
                            }
                            $nom = $row['Nom'];
                            $prenom = $row['Prenom'];
                            echo "</tr>";
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
                
            <?php 
            //S'il s'agit d'un élève, c'est ce code html qui s'exécute
            }else{ ?>
                <header>
                    <section>
                        <h1>Ecole Imaginaire Intranet</h1>
                        <nav>
                            <ul>
                                <li><a href="Accueil.php">Accueil</a></li>
                                <li><a href="Deconnexion.php">Se déconnecter</a></li>
                            </ul>
                        </nav>
                    </section>
                </header>
                <div>
                    <h2><?php echo "Bonjour ".$result[0]["Prenom"]." ".$result[0]["Nom"]; ?></h2>
                </div>
                <div id="eleve">
                    
                    <table>
                        <thead>
                            <tr>
                                <td>Elèves</td>
                                <td>Matière</td>
                                <td>Evaluation</td>
                                <td>Note</td>
                                <td>Remarque</td>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                        //On veut les notes de l'élève connecté
                        $sql3 = "select Utilisateurs.Pseudo, Nom, Prenom, releveNote.Matiere, releveNote.Evaluation, Note, Remarque from Utilisateurs, releveNote where Utilisateurs.pseudo = releveNote.pseudo and releveNote.pseudo = '".$_SESSION['login']."'";
                        $result3 = $databaseStudents->query($sql3);
                        //on veut la moyenne de l'élève connecté
                        $sql5 = $databaseStudents->prepare('select Nom, Prenom, round(avg(note),2) as moyenne from Utilisateurs, releveNote where Utilisateurs.pseudo = releveNote.pseudo and releveNote.pseudo = ? GROUP by NOM order by Prenom, releveNote.Matiere');
                        
                        $nom = $prenom = "";
                        
                        //affichage des éléments des requêtes ci-dessus
                        foreach($result3 as $row){
                            echo "<tr>";
                            if ($nom != $row['Nom'] and $prenom != $row['Prenom']){
                                $sql5->execute(array($row['Pseudo']));
                                $result5 = $sql5->fetchAll();
                                echo "<td>".$row['Prenom']." ".$row['Nom']."</td><td></td><td>Moyenne de l'élève</td><td>".$result5[0]['moyenne']."</td><td></td>";
                                echo "</tr><tr>";
                                echo "<td class='vide' rowspan='".$result6."'><img src='../Images/".$row['Pseudo']."' width='110' height='100'></td>";
                              
                                echo "<td>".$row['Matiere']."</td><td>".$row['Evaluation']."</td><td>".$row["Note"]."</td><td>".$row["Remarque"]."</td>";
                                
                            }else{
                                echo "<td class='vide'></td>";
                              
                                echo "<td>".$row['Matiere']."</td><td>".$row['Evaluation']."</td><td>".$row["Note"]."</td><td>".$row["Remarque"]."</td>";
                            }
                            $nom = $row['Nom'];
                            $prenom = $row['Prenom'];
                            echo "</tr>";
                        }
                    ?>
                        </tbody>
                    </table>
                </div>
            <?php }
            
        ?>
    </body>
</html>