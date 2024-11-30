<?php
    class utilisateur {
        public int $id;
        public string $nom; 
        public string $prenom;
        public string $pseudo;
        public string $email;
        public string $date_naissance;

        private $hash;

        /**
         * @param int $id
         * @param string $nom
         * @param string $prenom
         * @param string $pseudo
         * @param string $email
         * @param string $date_naissance
         */
        public function __construct(int $id, string $nom, string $prenom, string $pseudo, string $email, string $date_naissance)
        {
            $this->id = $id;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->pseudo = $pseudo;
            $this->email = $email;
            $this->date_naissance = $date_naissance;
        }

        public function existsOr() {
            try{
                $query = 'SELECT * FROM utilisateur AS u WHERE u.email = :em';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $statement->bindParam(':em', $this->email);
                $statement->execute();
                $mail = ($statement->rowCount() > 0);

                $query = 'SELECT * FROM utilisateur AS u WHERE u.pseudo = :ps';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $statement->bindParam(':ps', $this->pseudo);
                $statement->execute();
                $pseudo = ($statement->rowCount() > 0);
                return ($pseudo or $mail);
            }catch (PDOException $e){
                throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
            }
        }

        public function existsAnd() {
            try{
                $query = 'SELECT * FROM utilisateur AS u WHERE u.email = :em';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $statement->bindParam(':em', $this->email);
                $statement->execute();
                $mail = ($statement->rowCount() > 0);

                $query = 'SELECT * FROM utilisateur AS u WHERE u.pseudo = :ps';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $statement->bindParam(':ps', $this->pseudo);
                $statement->execute();
                $pseudo = ($statement->rowCount() > 0);

                return ($pseudo and $mail);
            }catch (PDOException $e){
                throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
            }
        }


        public function createUtilisateur($mdp){
            if(!$this->existsOr()){
                try{
                    $query = 'INSERT INTO utilisateur(nom, prenom, pseudo, email, date_naissance, password) VALUES (:no, :pr, :ps, :em, :dn, :pwd)';
                    $statement = BDD::getInstance()->getPDO()->prepare($query);
                    $hash = hash("sha256", $mdp);
                    $statement->bindParam(':no', $this->nom);
                    $statement->bindParam(':pr', $this->prenom);
                    $statement->bindParam(':ps', $this->pseudo);
                    $statement->bindParam(':em', $this->email);
                    $statement->bindParam(':dn', $this->date_naissance);
                    $statement->bindParam(':pwd', $hash);
                    $statement->execute();
                    return true;
                }catch (PDOException $e){
                    throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
                }
            }
            else{
                return false;
            }
        }

        public static function connexion($mail, $mdp){
            $user = new utilisateur(0,"","","",$mail,"");
            try{
                $query = 'SELECT * FROM utilisateur AS u WHERE u.email = :em and u.password = :pd';
                $statement = BDD::getInstance()->getPDO()->prepare($query);
                $hash = hash("sha256", $mdp);
                $statement->bindParam(':em', $mail);
                $statement->bindParam(':pd', $hash);
                $statement->execute();
                if ($statement->rowCount() == 1){
                    $row = $statement->fetch();
                    $user->setId($row["id"]);
                    $user->setNom($row["nom"]);
                    $user->setPrenom($row["prenom"]);
                    $user->setDateNaissance($row["date_naissance"]);
                    $user->setDateNaissance($row["date_naissance"]);
                    $user->setHash($hash);
                    return $user;
                }
            }catch (PDOException $e){
                throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
            }
            return false;
        }

        public static function verify($user){
            try{
                if($user) {
                    $query = 'SELECT * FROM utilisateur AS u WHERE u.email = :em and u.password = :pd';
                    $statement = BDD::getInstance()->getPDO()->prepare($query);

                    $mail = $user->getEmail();
                    $mdp_hashed = $user->getHash();

                    $statement->bindParam(':em', $mail);
                    $statement->bindParam(':pd', $mdp_hashed);
                    $statement->execute();
                    if ($statement->rowCount() == 1){
                        return true;
                    }
                }
            }catch (PDOException $e){
                throw new Exception("PDO Error - utilisateur.php: " . $e->getMessage());
            }
            return false;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getNom(): string
        {
            return $this->nom;
        }

        public function setNom(string $nom): void
        {
            $this->nom = $nom;
        }

        public function getPrenom(): string
        {
            return $this->prenom;
        }

        public function setPrenom(string $prenom): void
        {
            $this->prenom = $prenom;
        }

        public function getPseudo(): string
        {
            return $this->pseudo;
        }

        public function setPseudo(string $pseudo): void
        {
            $this->pseudo = $pseudo;
        }

        public function getEmail(): string
        {
            return $this->email;
        }

        public function setEmail(string $email): void
        {
            $this->email = $email;
        }

        public function getDateNaissance(): string
        {
            return $this->date_naissance;
        }

        public function setDateNaissance(string $date_naissance): void
        {
            $this->date_naissance = $date_naissance;
        }

        /**
         * @return mixed
         */
        public function getHash()
        {
            return $this->hash;
        }

        /**
         * @param mixed $hash
         */
        public function setHash($hash): void
        {
            $this->hash = $hash;
        }
    }
?>