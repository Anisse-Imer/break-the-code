<?php
    require_once("src/modele/bdd.php");
    require_once("src/modele/utils.php");
    require_once("src/modele/objectGame/partie.php");
    require_once("src/modele/objectGame/cartes/cartes.php");
    require_once("src/modele/ordi.php");

    require_once("src/modele/objectGame/partie_action/action.php");

    function jeu(){
        if($_SESSION["user"]){
            if($_SESSION['partie']){
                //var_dump($_SESSION['partie']->getTuiles()->getTuilesOrdi());
                if($_POST && $_POST["id"]){
                    $carte = json_decode($_POST['id']);
                    $res = $_SESSION['partie']->play($carte);
                    if($_SESSION['partie']-> getTour() >= 40){
                        $res = $_SESSION['partie']->proposition(    $_POST['code_tile_1'], $_POST['color_1'],
                            $_POST['code_tile_2'], $_POST['color_2'],
                            $_POST['code_tile_3'], $_POST['color_3'],
                            $_POST['code_tile_4'], $_POST['color_4'],
                            $_POST['code_tile_5'], $_POST['color_5']);
                        if($res){
                            $_SESSION["res"] = "win";
                            $_SESSION["partie"] = null;
                            header("Location: https://s5-gp5.kevinpecro.info/resultat");
                            exit();
                        }
                        else{
                            $_SESSION["res"] = "lose";
                            $_SESSION["partie"] = null;
                            header("Location: https://s5-gp5.kevinpecro.info/resultat");
                            exit();
                        }
                    }
                }
                elseif ($_POST && $_POST["valider"] && $_POST["valider"] == "TRUE"){
                    $res = $_SESSION['partie']->proposition(    $_POST['code_tile_1'], $_POST['color_1'],
                                                                $_POST['code_tile_2'], $_POST['color_2'],
                                                                $_POST['code_tile_3'], $_POST['color_3'],
                                                                $_POST['code_tile_4'], $_POST['color_4'],
                                                                $_POST['code_tile_5'], $_POST['color_5']);
                    if($res){
                        $_SESSION["res"] = "win";
                        $_SESSION["partie"] = null;
                        header("Location: https://s5-gp5.kevinpecro.info/resultat");
                        exit();
                    }
                    else{
                        $_SESSION["res"] = "lose";
                        $_SESSION["partie"] = null;
                        header("Location: https://s5-gp5.kevinpecro.info/resultat");
                        exit();
                    }
                }
                require('src/view/inc/inc.head.php');
                require('src/view/inc/inc.header.php');
                require('src/view/v-jeu.php');
            }
            else{
                try{
                    $id = $_SESSION["user"]->getId();
                    $_SESSION['partie'] = new partie($_SESSION["user"], $id);
                    require('src/view/inc/inc.head.php');
                    require('src/view/inc/inc.header.php');
                    require('src/view/v-jeu.php');
                }
                catch (Exception $e){
                    header("Location: https://s5-gp5.kevinpecro.info/login");
                    exit();
                }
            }
        }
        else{
            header("Location: https://s5-gp5.kevinpecro.info/login");
            exit();
        }
    }

    function testOrdi(){
        $l= [];
        $tuiles = new tuiles();
        $ordi = new ordi(array_slice($tuiles->tuiles,0,5) );


        $cartes = new cartes();
        $cartes->getCartesBD();

        $carteTrouve = null;

        foreach ($cartes->pioche as $carte) {
            if ($carte->id === "17") {
                $carteTrouve= $carte;
               }
        }
        #Choisir un carte

        var_dump($carteTrouve);
        var_dump("***********************************");
        #carte de l'ordinateur
        forEach($ordi->tuileOrdi as $tuile){
            echo $tuile->numero. "-";
        }
        var_dump($ordi->tuileOrdi);
        var_dump("***********************************");

        #regarder la valeur du retour
        $valRetour = $ordi->returnQuestions($carteTrouve);
        var_dump($valRetour);


    }
?>