<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$id = 7;
$nom = "fdsgfdsfdsfds";
$obj = "Dofdsfdsfdsfdsnne la mort";
$info = "Tu mefdsfdsfdsurs";
$effet = "Explfdsfdsfdsose ton ventre";
var_dump(PdoGsb::modifProduit($id,$nom,$obj,$info,$effet));
