<?php
    include ("tuile.php");

    class tuiles
    {
        public array $tuiles;
        public array $tuilesJoueur;
        public array $tuilesOrdi;

        public function getAllTuile(): void
        {
            try {
                $this->tuiles = BDD::getInstance()->get_results("SELECT t.*, c.code_couleur FROM tuile as t, couleur as c WHERE t.id_couleur=c.id;");
            } catch (Exception $e) {
                $this->tuiles = ["erreur" => $e->getMessage()];
            }
        }
        public function distribueTuile() :void
        {
            shuffle($this->tuiles);
            // Fonction de comparaison pour usort


            function comparerAtt($a, $b) {
                return $a->numero - $b->numero;
            }

            $tuilesJoueur= array_slice($this->tuiles, 0, 5);
            $tuilesOrdi= array_slice($this->tuiles, 6, 5);
            usort($tuilesJoueur, 'comparerAtt');
            usort($tuilesOrdi, 'comparerAtt');

            $this->tuilesJoueur= $tuilesJoueur;
            $this->tuilesOrdi = $tuilesOrdi;
        }

        function __construct()
        {
            $this->getAllTuile();
            $this->distribueTuile();
        }

        public function idsTuilesJoueur(){
            $ids = [];
            foreach ($this->tuilesJoueur as $tuile) {
                $ids[] = $tuile->id;
            }
            return $ids;
        }
        public function idsTuilesOrdi(){
            $ids = [];
            foreach ($this->tuilesOrdi as $tuile) {
                $ids[] = $tuile->id;
            }
            return $ids;
        }

        public function getTuiles(): array
        {
            return $this->tuiles;
        }

        public function getTuilesJoueur(): array
        {
            return $this->tuilesJoueur;
        }

        public function getTuilesOrdi(): array
        {
            return $this->tuilesOrdi;
        }
    }

?>