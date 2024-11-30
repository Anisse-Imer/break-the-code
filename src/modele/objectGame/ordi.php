<?php


class ordi
{
    public array $tuilesPossibles;
    public array $tuileOrdi;
    public array $listeCombinaison;

    /**
     * @param array $tuilesPossibles
     * @param array $tuileOrdi
     * @param array $listeCombinaison
     */
    public function __construct(array $tuileOrdi)
    {
        $this->tuileOrdi = $tuileOrdi;
    }


    public function initialTuilesPossibles($tuilesOrdi)
    {
        $listeTuileObject = new tuiles();
        $listeTuile = $listeTuileObject->tuiles;
        function comparerObjets($objet1, $objet2)
        {
            return $objet1->id - $objet2->id;
        }

        $this->tuilesPossibles = array_udiff($listeTuile, $tuilesOrdi, 'comparerObjets');
        $this->listeCombinaison = $this->generateCombinationsOfSize($this->tuilesPossibles, 5);
        $this->tuileOrdi = $tuilesOrdi;

    }

    public function generateCombinationsOfSize($items, $size, $combinaison = array(), $index = 0)
    {
        $combinations = array();

        if (count($combinaison) == $size) {
            $combinations[] = $combinaison;
            return $combinations;
        }

        for ($i = $index; $i < count($items); $i++) {
            $item = $items[$i];

            // Inclure l'élément actuel dans la combinaison
            $combinations = array_merge(
                $combinations,
                $this->generateCombinationsOfSize($items, $size, array_merge($combinaison, array($item)), $i + 1)
            );
        }

        return $combinations;
    }

    private function calculSomme($cartes)
    {
        $somme = 0;
        if (!($cartes->id_couleur)) {
            $position = explode(';', $cartes->position);
            foreach ($position as $value) {
                $somme += $this->tuileOrdi[$value]->numero;
            }
        } else {
            foreach ($this->tuileOrdi as $tuile) {
                if ($tuile->id_couleur == $cartes->id_couleur) {
                    $somme += $tuile->numero;
                }
            }
        }
        return $somme;
    }

    public function returnQuestions($cartes):string
    {
        switch ($cartes->type_carte) {
            case 'somme':
                $value = $this->calculSomme($cartes);
                break;
            case 'position':
                $value = $this->calculPosition($cartes);
                break;
            case 'nombre':
                $value = $this->calculNombre($cartes);
                break;
            case 'voisine':
                $value = $this->calculVoisine();
                break;
            case 'suive':
                $value = $this->calculSuivre();
                break;
            case 'superieur':
                $value = $this->calculSuperieur($cartes);
                break;
            case 'egaux':
                $value = $this->calculEgaux();
                break;
            case 'difference':
                $value = $this->calculDifference();
                break;
        }
        if (is_array($value)) {
            $chaineResultat = implode(', ', $value);
            $chaineResultat = preg_replace('/,(?=[^,]*$)/', ' et', $chaineResultat);
            return  "La réponse à la question est : " . $chaineResultat;

        }
       return "La réponse à la question est " . $value;
    }


    private function calculPosition($cartes)
    {
        $valeurs = explode(';', $cartes->valeur);
        $positionTuiles = [];
        $listTuile = ["a","b","c","d","e"];
        #si il y a plus d'une valeur possible on melange pour regarder laquel on regarde en premier
        if (count($valeurs) > 1) {
            shuffle($valeurs);
        }
        foreach ($valeurs as $valeur) {
            $indexPosition = 0;
            foreach ($this->tuileOrdi as $tuile) {
                if ($tuile->numero == $valeur) {
                    array_push($positionTuiles, $listTuile[$indexPosition]);
                }
                $indexPosition += 1;
            }
            if (count($positionTuiles) > 0) {
                return $positionTuiles;
            }
        }

        return "il n'y en a pas";
    }

    private function calculNombre($cartes)
    {
        $somme = 0;

        foreach ($this->tuileOrdi as $tuile) {
            if ($tuile->id_couleur == (int)$cartes->id_couleur) {
                $somme += 1;
            }
        }
        return $somme;
    }

    private function calculVoisine()
    {
        $listTuile = ["a","b","c","d","e"];
        $listVoisin = [];
        $indexParcours = 0;
        $flagEnCours = false;
        while ($indexParcours < count($this->tuileOrdi)) {
            if ((int)$this->tuileOrdi[$indexParcours]->id_couleur == ((int)$this->tuileOrdi[$indexParcours + 1]->id_couleur)) {
                if (end($listVoisin) === $indexParcours) {
                    $flagEnCours = true;
                    array_push($listVoisin, $listTuile[$indexParcours + 1]);
                } else {
                    $flagEnCours = true;
                    array_push($listVoisin, $listTuile[$indexParcours]);
                    array_push($listVoisin, $listTuile[$indexParcours + 1]);
                }
            } else {
                if ($flagEnCours) {
                    $flagEnCours = false;
                    array_push($listVoisin, 'x');
                }
            }
            $indexParcours += 1;
        }
        if (count($listVoisin)>0){
            return $listVoisin;
        }
        return "il n'y en a pas";
    }

    private function calculSuivre()
    {
        $listTuile = ["a","b","c","d","e"];
        $listVoisin = [];
        $indexParcours = 0;
        $flagEnCours = false;
        while ($indexParcours < count($this->tuileOrdi)) {
            if ((int)$this->tuileOrdi[$indexParcours]->numero == ((int)$this->tuileOrdi[$indexParcours + 1]->numero - 1)) {
                if (end($listVoisin) === $indexParcours) {
                    $flagEnCours = true;
                    array_push($listVoisin, $listTuile[$indexParcours + 1]);
                } else {
                    $flagEnCours = true;
                    array_push($listVoisin, $listTuile[$indexParcours]);
                    array_push($listVoisin, $listTuile[$indexParcours + 1]);
                }
            } else {
                if ($flagEnCours) {
                    $flagEnCours = false;
                    array_push($listVoisin, 'x');
                }
            }
            $indexParcours += 1;
        }
        if (count($listVoisin)>0){
            return $listVoisin;
        }
        return "il n'y en a pas";
    }

    private function calculSuperieur($cartes)
    {
        if (((int)$cartes->valeur) < ((int)$this->tuileOrdi[$cartes->position]->numero)) {
            return "vrai";
        }
        return "faux";
    }

    private function calculEgaux()
    {
        $chiffreTuiles = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
        $somme = 0;
        foreach ($this->tuileOrdi as $tuile) {
            $chiffreTuiles[(int)$tuile->numero] += 1;
        }
        foreach ($chiffreTuiles as $value) {
            if ($value > 1) {
                $somme += $value;
            }
        }

        return $somme;
    }
    private function calculDifference() {
        return (int)$this->tuileOrdi[4]->numero - (int)$this->tuileOrdi[0]->numero ;
    }
}


