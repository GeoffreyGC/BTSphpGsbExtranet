<?php

include('../include/class.pdogsb.inc.php');

$nom="Dupont";
$id=8;

$pdo = PdoGsb::getPdoGsb();

$modif= $pdo->modifNom($nom,$id);