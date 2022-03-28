<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$nom = "Dupirette";
$objectif = "Donne la mort";
$url = "www.uhgigegejgoiudfshgi.fr";
$date = "2021-02-15";
var_dump(PdoGsb::ajouteVisio($nom, $objectif, $url, $date));
