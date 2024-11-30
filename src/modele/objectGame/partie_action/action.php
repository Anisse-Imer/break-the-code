<?php
    class action {
        public int $id;
        public int $id_partie;
        public int $id_utilisateur;
        public int $id_carte;
        public string $proposition;

        public string $reponse;

        /**
         * @param int $id
         * @param int $id_partie
         * @param int $id_utilisateur
         * @param int $id_carte
         * @param string $proposition
         * @param string $reponse
         */
        public function __construct(int $id, int $id_partie, int $id_utilisateur, int $id_carte, string $proposition, string $reponse)
        {
            $this->id = $id;
            $this->id_partie = $id_partie;
            $this->id_utilisateur = $id_utilisateur;
            $this->id_carte = $id_carte;
            $this->proposition = $proposition;
            $this->reponse = $reponse;
        }

        public function save(){
            try{
                $query = 'INSERT INTO partie_action (id_partie, id_utilisateur, id_carte, proposition, reponse) VALUES(:idp, :uid, :idc, :prp,:res)';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $statement->bindParam(':idp', $this->id_partie);
                $statement->bindParam(':uid', $this->id_utilisateur);
                $statement->bindParam(':idc', $this->id_carte);
                $statement->bindParam(':prp', $this->proposition);
                $statement->bindParam(':res', $this->reponse);
                $statement->execute();
                return true;
            }
            catch (Exception $e){
                return false;
            }
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getIdPartie(): int
        {
            return $this->id_partie;
        }

        public function setIdPartie(int $id_partie): void
        {
            $this->id_partie = $id_partie;
        }

        public function getIdUtilisateur(): int
        {
            return $this->id_utilisateur;
        }

        public function setIdUtilisateur(int $id_utilisateur): void
        {
            $this->id_utilisateur = $id_utilisateur;
        }

        public function getIdCarte(): int
        {
            return $this->id_carte;
        }

        public function setIdCarte(int $id_carte): void
        {
            $this->id_carte = $id_carte;
        }

        public function getProposition(): string
        {
            return $this->proposition;
        }

        public function setProposition(string $proposition): void
        {
            $this->proposition = $proposition;
        }

        public function getReponse(): string
        {
            return $this->reponse;
        }

        public function setReponse(string $reponse): void
        {
            $this->reponse = $reponse;
        }
    }
?>