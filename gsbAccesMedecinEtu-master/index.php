
<?php
require_once("include/fct.inc.php");
require_once ("include/class.pdogsb.inc.php");
session_start();



date_default_timezone_set('Europe/Paris');



$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();

if(isset($_COOKIE['CookieAccepter']) || isset($_COOKIE['CookieRefuser'])) {
$_SESSION["showcookie"] = false;
} else {
$_SESSION["showcookie"] = true;
}
   
if(!isset($_GET['uc'])){
     $_GET['uc'] = 'connexion';
}
else {
    if($_GET['uc']=="connexion" && !estConnecte()){
        $_GET['uc'] = 'connexion';
    }
        
}

$uc = $_GET['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
        case 'creation':{
		include("controleurs/c_creation.php");break;
	}
        
        case 'droit' :{
            include ("controleurs/c_droit.php");break;
            
        }
        
        case 'visio' :{
            include("controleurs/c_visio.php");break;
        }
        
        case 'produit':{
                include ('controleurs/c_produit.php');break;
        }
        
        case 'maintenance':{
                include ('controleurs/c_maintenance.php');break;
        }

	}

        
$etat = PdoGsb::etatServeur();
if ($etat == 0){            
        header('Location: vues/v_maintenance.php');
        exit();
}

include_once("vues/v_footer.php");

   

?>







