<?php
include ('cartes/cartes.php');
include ('grilles/grille.php');
include ('partie_action/actions.php');
include ("utilisateur/utilisateur.php");

class partie
{
    public cartes $cartesEnJeu;
    public tuiles $grillesJoueurs;
    public actions $partieAction;
    public $idPartie;
    public utilisateur $joueur;
    public $tour;
    private $id;

    // On part du principe ici que l'utilisateur a bien été vérifié
    function gameFinished(){
        try{
            $query = 'select * from partie as p where p.id_utilisateur = :uid and p.resultat = -1';
            $statement = BDD::getInstance()->getPDO()->prepare($query);
            $id = $this->joueur->getId();
            $statement->bindParam(':uid', $id);
            if($statement->execute() and $statement->rowCount() > 0){
                return false;
            }
            else{
                return true;
            }
        }catch (PDOException $e){
            throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
        }
    }

    function newGame(){}

    function continueGame(){}

    function __contruct(utilisateur $utilisateur){
        if($utilisateur->existsAnd()){
            echo "Jeu - CONSTRUCT - PLAYER EXISTS";
            $this->joueur = $utilisateur;
            $this->checkLastGame();
        }
        else{
            throw new Exception("Utilisateur n'existe pas - jeu.php: ");
        }
    }
}
