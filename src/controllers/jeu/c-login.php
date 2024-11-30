<?php

require_once('src/modele/bdd.php');

function login()
{   
    if($_POST && isset($_POST)){
        $user = utilisateur::connexion($_POST["email"], $_POST["password"]);
        if($user){
            $_SESSION["user"] = $user;
            header("Location: https://s5-gp5.kevinpecro.info/adversaire");
            exit();
        }
        else{
            header("Location: https://s5-gp5.kevinpecro.info/login");
            exit();
        }
    }
    require('src/view/inc/inc.head.php');
    require('src/view/inc/inc.header.php');
    require('src/view/login/v-login.php');
}