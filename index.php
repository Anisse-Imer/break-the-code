<?php
    require_once('src/controllers/jeu/c-accueil.php');
    require_once('src/controllers/jeu/c-jeu.php');
    require_once('src/controllers/jeu/testBDD.php');
    require_once('src/controllers/jeu/c-login.php');
    require_once('src/controllers/jeu/c-register.php');
    require_once('src/controllers/jeu/c-resultat.php');
    require_once('src/controllers/jeu/c-adversaire.php');
    require_once('src/controllers/statistiques/c-stats.php');
    session_start();
    if(isset($_GET['url']) && $_GET['url']) {
        $url = rtrim($_GET['url'], '/');
        if ($url) {
            switch ($url) {
                case 'test':
                    testOrdi();
                    break;
                case 'jeu':
                    jeu();
                    break;
                case 'grille':
                    grille();
                    break;
                case 'utilisateur':
                    utilisateur();
                    break;
                case 'login':
                    login();
                    break;
                case 'register':
                    register();
                    break;
                case 'adversaire':
                    adversaire();
                    break;
                case 'statistiques':
                    statistiques();
                    break;
                case 'resultat':
                    resultat();
                    break;
                case 'testbdd':
                    testBDD();
                    break;
                default:
                    accueil();
                    break;
            }
        }
    }
    else{
        accueil();
    }
?>