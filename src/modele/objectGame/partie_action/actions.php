<?php
    include ("action.php");
    class actions{
        public array $actions;

        public function __construct()
        {
            $this->actions = array();
        }

        public function push($action){
            if($action->save()){
                $this->actions[] = $action;
            }
        }

        public function reconstruct(int $id_partie){

        }
    }
?>