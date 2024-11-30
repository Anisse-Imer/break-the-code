<?php
 function getAllTuile(){
     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
         http_response_code(405);
         die("Méthode non autorisé");
     }
//   if (!isset($_POST['token']) || $_POST['token'] !== 'Z0g4c1Q0cEx6TjZ5RjJrWDdjRDVtQjFyVjNqRTB3UQ=='){
//             http_response_code(401);
//             die("Non autorisé");
//   }


 }
 ?>