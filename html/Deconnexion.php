<?php
    session_start();
    //Desctruction de la session actuelle (vide toutes les données de la globale $_SESSION)
    session_destroy();
    header('Location: ../Index.php');
    exit;
?>