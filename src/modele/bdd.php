<?php
    function getConnection($port, $host, $username, $password, $base){
        /** Permet de lancer une instance de connexion à la base de donnée
        IN : _
        OUT : instance de base pdo */
        // On commence par fermer la connexion si elle existait
        $pdo = null;

        // On essaie de se connecter
        try{
            $pdo = new PDO("mysql:host=" . $host . ";port=" . $port. ";dbname=" . $base . ";charset=utf8", $username, $password);
            $pdo->exec("set names utf8"); // On force les transactions en UTF-8
        }catch(PDOException $exception){ // On gère les erreurs éventuelles
            echo "Erreur de connexion : " . $exception->getMessage();
        }
        return $pdo;
    }

    class BDD {
        // The instance of the class is stored here.
        private static $instance = null;
        private $pdo = null;
        private $port=3386;
        private $host = "localhost";
        private $username = "s5-gp5";
        private $password = "eV4#TtLz7DyJ";
        private $base = "s5-gp5";

        // Private constructor to prevent direct instantiation from outside the class.
        private function __construct() {
            $this->pdo = getConnection($this->port, $this->host, $this->username, $this->password, $this->base);
        }

        // Method to get the singleton instance.
        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        public function getPDO(){
            return $this->pdo;
        }

        public function get_result($requete){


            /** fonction GET pour recupérer une donnée
             *IN : La requête BD
             * OUT : Le reçu de la requête en tableau associatif
             */

            if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
                http_response_code(405);
                throw new Exception('"Méthode non autorisé"');
            }
            try {
                $requete = $this->pdo->query($requete);
            }catch(Exception $e){
                throw new Exception('erreur BD');
            }
            return $requete->fetch(PDO::FETCH_OBJ);
        }

        public function get_results($requete)
            /** fonction GET pour recupérer plusieurs données
             *IN : La requête BD
             * OUT : Le reçu de la requête en tableau associatif
             */
        {
            try {
                $requete = $this->pdo->query($requete);
            } catch (Exception $e) {
                throw new Exception('erreur BD' . $e->getMessage());
            }
            return $requete->fetchAll(PDO::FETCH_OBJ);
        }
        public function post_result($requete)
            /** fonction POST pour envoyer une donnée
             *IN : La requête BD
             * OUT : _
             */
        {
            global $pdo;
            $pdo->execute($requete);
        }

    }
?>