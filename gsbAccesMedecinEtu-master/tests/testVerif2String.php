<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/fct.inc.php");

//appel de la fonction qui permet de se connecter à la base de données


$chaine1 = "salut";
$chaine2 = "salut";


var_dump(verif2Strings($chaine1, $chaine2)); 



$chaine3 = "salut";
$chaine4 = "MOI";

var_dump(verif2Strings($chaine3, $chaine4));


