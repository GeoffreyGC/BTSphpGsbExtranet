<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$id = 3;
$nom = "Dupitre";
$prenom = "Mathéaq";


var_dump(PdoGsb::modifNomPrenom($nom, $prenom, $id));