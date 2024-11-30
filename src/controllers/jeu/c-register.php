<?php
    require_once('src/modele/bdd.php');

    function register()
    {
        if($_POST && isset($_POST)){
            $user = new utilisateur(
                0,
                $_POST["prenom"],
                $_POST["nom"],
                $_POST["pseudo"],
                $_POST["email"],
                $_POST["date_naissance"]);
            if($user && isset($user)){
                if($user->createUtilisateur($_POST["password"])){
                    $_SESSION["user"] = utilisateur::connexion($_POST["email"], $_POST["password"]);
                    header("Location: https://s5-gp5.kevinpecro.info/adversaire");
                    exit();
                }
                else{
                    header("Location: https://s5-gp5.kevinpecro.info/register");
                    exit();
                }
            }
            else{
                header("Location: https://s5-gp5.kevinpecro.info/register");
                exit();
            }
        }
        require('src/view/inc/inc.head.php');
        require('src/view/inc/inc.header.php');
        require('src/view/register/v-register.php');
    }
?>