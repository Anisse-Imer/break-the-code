<?php
    function pageTestTuile(){

        require_once('src/modele/bdd.php');
        include ("src/modele/objectGame/cartes/cartes.php");
        include ("src/modele/objectGame/grilles/grille.php");
        include ("src/modele/objectGame/partie_action/partie_actions.php");
        include ("src/modele/objectGame/utilisateur/utilisateur.php");
        include ("src/modele/objectGame/cartes/carte.php");
        include ("src/modele/objectGame/cartes/cartes.php");
        include ("src/modele/bdd.php");


        $cnx = ConnexionBase::getInstance();
        $cartes = new cartes($cnx->pdo);
        $cartes->getCartesBD();
        var_dump($cartes);
    }
?>