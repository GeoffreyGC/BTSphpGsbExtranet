<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$nom = "Dupirette";
$obj = "Donne la mort";
$info = "Tu meurs";
$effet = "Explose ton ventre";
var_dump(PdoGsb::AjouteProduit($nom,$obj,$info,$effet));
