<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$id = 3;
$nom = "Chapittre";
$prenom = "Goffrette";
$mdp = "LeMDP";

var_dump(PdoGsb::modifNomPrenomMdp($nom, $prenom, $mdp, $id));