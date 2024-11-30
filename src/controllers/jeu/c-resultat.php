<?php
    include('src/view/inc/inc.head.php');
    include('src/view/inc/inc.header.php');

    function resultat(){
        if($_SESSION["res"]){
            if($_SESSION["res"] && $_SESSION["res"] == "win"){
                include('src/view/resultat/v-resultat_win.php');
            }
            else{
                include('src/view/resultat/v-resultat_lose.php');
            }
        }
        else{
            header("Location: https://s5-gp5.kevinpecro.info");
            exit();
        }
        $_SESSION["res"] = null;
    }
?>