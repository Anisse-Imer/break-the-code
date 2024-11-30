<?php
    class carte {
        public int $id;
        public string $type;
        public string $valeur;
        public int $position;
        public string $couleur;
        public bool $parite;
        public int $question;

        public function __construct($id = null,$type =null,$valeur=null,$position=null,$couleur=null,$parite=null,$question=null){
            $this->id= $id;
            $this->type=$type;
            $this->valeur=$valeur;
            $this->position=$position;
            $this->couleur= $couleur  ;
            $this->parite=$parite;
            $this->question=$question;
        }

        public function getId(): int
        {
            return $this->id;
        }

        public function setId(int $id): void
        {
            $this->id = $id;
        }

        public function getType(): string
        {
            return $this->type;
        }

        public function setType(string $type): void
        {
            $this->type = $type;
        }

        public function getValeur(): string
        {
            return $this->valeur;
        }

        public function setValeur(string $valeur): void
        {
            $this->valeur = $valeur;
        }

        public function getPosition(): int
        {
            return $this->position;
        }

        public function setPosition(int $position): void
        {
            $this->position = $position;
        }

        public function getCouleur(): string
        {
            return $this->couleur;
        }

        public function setCouleur(string $couleur): void
        {
            $this->couleur = $couleur;
        }

        public function isParite(): bool
        {
            return $this->parite;
        }

        public function setParite(bool $parite): void
        {
            $this->parite = $parite;
        }

        public function getQuestion(): int
        {
            return $this->question;
        }

        public function setQuestion(int $question): void
        {
            $this->question = $question;
        }


    }
?>