<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$id = 3;
$nom = "egfe";
$obj = "dsfdsf";
$date = "2025-05-30";
$url = "www.sfdiujhs.fr";

var_dump(PdoGsb::modifVisio($nom, $obj, $url, $date, $id));
