<?php
//on insère le fichier qui contient les fonctions
require_once ("../include/class.pdogsb.inc.php");

//appel de la fonction qui permet de se connecter à la base de données
$lePdo = PdoGsb::getPdoGsb();

$mail = 'geoffrey.chapit@gmail.com';

$mailcrypte = PdoGsb::hashMail($mail);
echo $mailcrypte;


//$maildecrypte = PdoGsb::decrypteMail($mailcrypte);
//echo $maildecrypte;
