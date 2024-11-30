<?php
include ('cartes/cartes.php');
include ('grilles/grille.php');
include ('partie_action/actions.php');
include ("utilisateur/utilisateur.php");
include ("ordi.php");

class partie
{
    public $id;
    public utilisateur $joueur;
    public int $premier_joueur;
    public cartes $cartes;
    public tuiles $tuiles;
    public actions $partieAction;
    public ordi $ordi;
    public ordi $joueurOrdi;
    public string $notes;

    public int $tour;



    // On part du principe ici que l'utilisateur a bien été vérifié
    function gameFinished(){
        try{
            $query = 'select * from partie as p where p.id_utilisateur = :uid and p.resultat = -1';
            $statement = BDD::getInstance()->getPDO()->prepare($query);
            $id = $this->joueur->getId();
            $statement->bindParam(':uid', $id);
            return $statement->execute() and $statement->rowCount() == 0;
        }catch (PDOException $e){
            throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
        }
    }

    function newGame(int $premier_joueur){
        $this->notes = "";
        // - Set the first player
        $this->setPremierJoueur($premier_joueur);
        // - Cards init
        $this->setCartes(new cartes());
        $this->cartes->getCartesBD();
        $this->cartes->melangePioche();
        $this->cartes->pioche6Carte();
        // - Tiles init
        $this->setTuiles(new tuiles());
        // - Parties-actions
        $this->setPartieAction(new actions());
        // Lance ordi
        $tuilesOrdi = $this->tuiles->getTuilesOrdi();
        $this->ordi = new ordi($tuilesOrdi);
        $tuilesJoueur = $this->tuiles->getTuilesJoueur();
        $this->joueurOrdi = new ordi($tuilesJoueur);
        // - Add it in base
        $this->savePartie();
        // Init tour
        $this->tour = 0;
    }

    function continueGame(){
        try{
            $query = 'select * from partie as p where p.id_utilisateur = :uid and p.resultat = -1';
            $statement = BDD::getInstance()->getPDO()->prepare($query);
            $id = $this->joueur->getId();
            $statement->bindParam(':uid', $id);
            if($statement->execute()){
                $donnees_partie = $statement->fetchAll();
                // Reconstruire les variables des classes avec ça
            }
        }catch (PDOException $e){
            throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
        }
    }

    function __construct(utilisateur $utilisateur, int $premier_joueur){
        if($utilisateur::verify($utilisateur)){
            $this->joueur = $utilisateur;
            // if($this->gameFinished())
            if(true){
                $this->premier_joueur = $premier_joueur;
                $this->newGame($premier_joueur);
            }
            else {
                $this->continueGame();
            }
        }
        else{
            throw new Exception("Utilisateur n'existe pas - partie.php - email/pwd incorrects");
        }
    }

    private function savePartie(){
        try{
            $query = 'INSERT INTO partie (id_utilisateur, premier_joueur, date_debut, date_fin, resultat, tuile_joueur, tuile_ia, cartes)
                      VALUES (:uid, :pj, :date, NULL, -1, :tlJO, :tlIA, :car);';

            $uid = $this->joueur->getId();
            $pj = $this->getPremierJoueur();

            $timezone = new DateTimeZone('Europe/Paris');
            $currentDateTime = new DateTime('now', $timezone);
            $date = $currentDateTime->format('Y-m-d H:i:s');

            $tlJO = utils::arrayToString($this->tuiles->idsTuilesOrdi());
            $tlIA = utils::arrayToString($this->tuiles->idsTuilesJoueur());
            $cartes = utils::arrayToString($this->cartes->idsJeu());

            $statement = BDD::getInstance()->getPDO()->prepare($query);
            $statement->bindParam(':uid', $uid);
            $statement->bindParam(':pj', $pj);
            $statement->bindParam(':date', $date);
            $statement->bindParam(':tlJO', $tlJO);
            $statement->bindParam(':tlIA', $tlIA);
            $statement->bindParam(':car', $cartes);
            $statement->execute();
            $this->id = BDD::getInstance()->getPDO()->lastInsertId();

            return true;
        }catch (Exception $e){
            return false;
        }
    }

    // Input    ---> id carte
    // output   ---> reponse de l'ordi
    public function play($carte){
        $this->tour = $this->tour + 2;
        // recup reponse grâce à l'ordi
        $result = [];
        $reponse = $this->ordi->returnQuestions($carte);
        $result["reponse"] = $reponse;
        $result["carte"] = $carte;
        // Entre l'action dans la base
        $act = new action(0
            , (int)$this->getId()
            , (int)$this->joueur->getId()
            , (int)$carte->id
            , ""
            , (string)$reponse);
        $act->save();
        // Entre l'action dans les classes
        $this->cartes->choisieCarteIndex((int)$carte->id);

        // Make ordi play - save ordi play
        $carteOrdi = $this->cartes->carteAuHasard();
        $this->cartes->choisieCarteIndex((int)$carteOrdi->id);
        // save computer card
        $result["carteOrdi"] = $carteOrdi;
        // get response of computer card
        $reponseOrdi = $this->joueurOrdi->returnQuestions($carteOrdi);
        $result["reponseOrdi"] = $reponseOrdi;
        // Save computer action
        $act = new action(0
            , (int)$this->getId()
            , 0
            , (int)$carteOrdi->id
            , ""
            , (string)$reponseOrdi);
        $act->save();
        return $result;
    }

    // Input    --->
    // tasks    ---> finir la partie dans la base - sauvegarder le gagnant
    // output   ---> resultat
    public function proposition($num1,$color1,$num2,$color2,$num3,$color3,$num4,$color4,$num5,$color5){
        $t = $this->tuiles->getTuilesOrdi();
        if( $t[0]->numero == $num1 && $t[0]->code_couleur == $color1
            && $t[1]->numero == $num2 && $t[1]->code_couleur == $color2
            && $t[2]->numero == $num3 && $t[2]->code_couleur == $color3
            && $t[3]->numero == $num4 && $t[3]->code_couleur == $color4
            && $t[4]->numero == $num5 && $t[4]->code_couleur == $color5){

            $query = "UPDATE partie SET date_fin = :dt, resultat = :res WHERE id = :uid";

            $statement = BDD::getInstance()->getPDO()->prepare($query);

            $timezone = new DateTimeZone('Europe/Paris');
            $currentDateTime = new DateTime('now', $timezone);
            $date = $currentDateTime->format('Y-m-d H:i:s');

            $statement->bindParam(':dt', $date);
            $statement->bindParam(':res', $this->joueur->id);
            $statement->bindParam(':uid', $this->id);

            $statement->execute();

            return true;
        }
        else{
            $query = "UPDATE partie SET date_fin = :dt, resultat = :res WHERE id = :uid";

            $statement = BDD::getInstance()->getPDO()->prepare($query);

            $timezone = new DateTimeZone('Europe/Paris');
            $currentDateTime = new DateTime('now', $timezone);
            $date = $currentDateTime->format('Y-m-d H:i:s');

            $statement->bindParam(':dt', $date);
            $res = 0;
            $statement->bindParam(':res', $res);
            $statement->bindParam(':uid', $this->id);

            $statement->execute();
            return false;
        }
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function getTuilesProp(): array
    {
        return $this->tuilesProp;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getJoueur(): utilisateur
    {
        return $this->joueur;
    }

    public function setJoueur(utilisateur $joueur): void
    {
        $this->joueur = $joueur;
    }

    public function getPremierJoueur(): int
    {
        return $this->premier_joueur;
    }

    public function setPremierJoueur(int $premier_joueur): void
    {
        $this->premier_joueur = $premier_joueur;
    }

    public function getCartes(): cartes
    {
        return $this->cartes;
    }

    public function setCartes(cartes $cartes): void
    {
        $this->cartes = $cartes;
    }

    public function getTuiles(): tuiles
    {
        return $this->tuiles;
    }

    public function setTuiles(tuiles $tuiles): void
    {
        $this->tuiles = $tuiles;
    }

    public function getPartieAction(): actions
    {
        return $this->partieAction;
    }

    public function setPartieAction(actions $partieAction): void
    {
        $this->partieAction = $partieAction;
    }

    public function getTour(): int
    {
        return $this->tour;
    }
}
