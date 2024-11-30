<?php

class ConnexionBase
{
    // Propriétés de la base de données
    private static $instance;  // The single instance of the class
    private function __construct()
    {
        $this->getConnection();
    }

    public static function getInstance()
    {
        // Create and return the single instance of the class
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function getPDO(){
        return self::getInstance()->pdo;
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