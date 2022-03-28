<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/fct.inc.php");

//appel de la fonction qui permet de se connecter à la base de données


$lePWD = "Azerty12:::";
var_dump(verifSecuPWP($lePWD));



$lePWD2 = "azertrdsgfdgfdhhhfdgfddrs";
var_dump(verifSecuPWP($lePWD2));