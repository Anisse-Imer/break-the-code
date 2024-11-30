<?php

function statistiques() {
    if($_SESSION["user"]){
        $queryNbPartie = "select count(id) as nombre from partie as p where p.id_utilisateur = :uid and p.resultat != -1";
        $statement = BDD::getInstance()->getPDO()->prepare($queryNbPartie);
        $statement->bindParam(':uid', $_SESSION["user"]->id);
        $statement->execute();
        $data = $statement->fetch();
        $nombrePartie = $data["nombre"];

        $queryNbPartie = "select count(id) as nombre from partie as p where p.id_utilisateur = :uid and p.resultat != -1 and p.resultat != 0";
        $statement = BDD::getInstance()->getPDO()->prepare($queryNbPartie);
        $statement->bindParam(':uid', $_SESSION["user"]->id);
        $statement->execute();
        $data = $statement->fetch();
        $nombreVictoire = $data["nombre"];
        (int)$nombreDefaite = (int)$nombrePartie - (int)$nombreVictoire;
        (float)$ratio = (float)$nombreVictoire / (float)$nombrePartie;

        include('src/view/inc/inc.head.php');
        include('src/view/inc/inc.header.php');
        include('src/view/statistiques/v-stats.php');
        include ('src/view/inc/inc.footer.php');
    }
    else{
        header("Location: https://s5-gp5.kevinpecro.info/login");
        exit();
    }
}
?>