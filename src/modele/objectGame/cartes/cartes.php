<?php
    require_once ("src/modele/bdd.php");
    class cartes
    {
        public array $pioche;
        private array $jeu;
        private array $cimetiere;
        private int $cartePioche;
        private int $carteTotal;

        public function __construct()
        {
            $this->pioche = array();
            $this->jeu = array();
            $this->cimetiere = array();
            $this->cartePioche = 0;
            $this->carteTotal = 0;
        }
        public function getCartesBD(){
            /**
             * Recupére toutes les cartes en BD et les mets dans l'objet pioche

             */
            $this->pioche = BDD::getInstance()->get_results("SELECT cartes.*, types_cartes.type_carte FROM cartes, types_cartes where cartes.id_type_carte=types_cartes.id;");
            $this->melangePioche();
        }
        public function melangePioche(){
            /**
             * Melange la pioche
             */
            shuffle($this->pioche);
        }
        private function recupCimtiere(){
            /**
             * Ajoute le cimtière dans la pioche
             */
            //Si la pioche n'est pas vide pour pas perdre de cartes
            $this->pioche = array_merge( $this->cimetiere,$this->pioche);
            $this->cimetiere = array();
            $this->cartePioche=0;
        }

        public function pioche6Carte(){
            /**
             * Initilise les 6 cartes du jeu
             */
            $this->cartePioche = $this->cartePioche + 6;

            //on vérifie si c'est possible de piocher 6 cartes avant de les piochers
            if ($this->cartePioche> count($this->pioche)) {
                $this->recupCimtiere();
                $this->melangePioche();
                $this->cartePioche =6 ;
            }
            $this->jeu = array_merge($this->jeu, array_slice($this->pioche, 0, 6));
            $this->pioche = array_slice($this->pioche, 6, count($this->pioche));
        }
        public function pioche1Carte(){
            /**
             * Pour piocher une nouvelle carte qui remplacera l'ancienne
             */
            $this->cartePioche = $this->cartePioche + 1;

            //Si la pioche est vide
            if (count($this->pioche) == 0) {
                $this->recupCimtiere();
            }
            $this->jeu = array_merge($this->jeu, array_slice($this->pioche, 0, 1));
            $this->pioche = array_slice($this->pioche, 1, count($this->pioche));
        }

        function choisieCarte($num){
            if(isset($this->jeu[$num])){
                $this->cimetiere[] = $this->jeu[$num];
                unset($this->jeu[$num]);
                $this->pioche1Carte();
            }
        }

        function choisieCarteIndex($indexCarte){
            foreach ($this->jeu as $carte){
                if($carte->id == $indexCarte){
                    $index = array_search($carte, $this->jeu, true);
                    $this->cimetiere[] = $this->jeu[$index];
                    unset($this->jeu[$index]);
                    $this->pioche1Carte();
                }
            }
        }

        function carteAuHasard(){
            return $this->jeu[random_int(0,4)];
        }

        public function getPioche(): array
        {
            return $this->pioche;
        }
        public function remplaceUneCarte($indexCarte){
            /**
             *Remplace une carte du jeu par une carte de la pioche
             */
            $this->affiche();
            $this->cartePioche = $this->cartePioche + 1;

            //Si la pioche est vide
            if (count($this->pioche) == 0) {
                $this->recupCimtiere();
                $this->melangePioche();
                $this->cartePioche=1;
            }
            array_push($this->cimetiere,$this->jeu[$indexCarte]);
            $this->jeu[$indexCarte] = array_pop($this->pioche);
        }

        public function idsJeu(){
            $ids = [];
            foreach ($this->jeu as $carte) {
                $ids[] = $carte->id;
            }
            return $ids;
        }

        public function setPioche(array $pioche): void
        {
            $this->pioche = $pioche;
        }

        public function getJeu(): array
        {
            return $this->jeu;
        }

        public function setJeu(array $jeu): void
        {
            $this->jeu = $jeu;
        }

        public function getCimetiere(): array
        {
            return $this->cimetiere;
        }

        public function setCimetiere(array $cimetiere): void
        {
            $this->cimetiere = $cimetiere;
        }

        public function getCartePioche(): int
        {
            return $this->cartePioche;
        }

        public function setCartePioche(int $cartePioche): void
        {
            $this->cartePioche = $cartePioche;
        }

        public function getCarteTotal(): int
        {
            return $this->carteTotal;
        }

        public function setCarteTotal(int $carteTotal): void
        {
            $this->carteTotal = $carteTotal;
        }

        public function affiche(){
            echo " <br> PIOCHE - ||||||";
            foreach($this->pioche as $carte){
                echo $carte->id . " :";
            }
            echo " <br> JEU - ||||||";
            foreach($this->jeu as $carte){
                echo $carte->id . " :";
            }
            echo " <br> CIMETIERE - ||||||";
            foreach($this->cimetiere as $carte){
                echo $carte->id . " :";
            }
        }
    }
?>