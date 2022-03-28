<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'selectmaintenance';
}
$action = $_GET['action'];
switch($action){
	
	case 'selectmaintenance':{
		include("vues/v_parametre.php");
		break;
	}
        
        case 'selectmaintenancev2':{
		include("vues/v_parametre2.php");
		break;
	}
        
        case 'selectmaintenance2':{
            
            $m = $_POST['m1'];
            $y = "yes";
            $n = "no";
            if($m == $y){
                $maintenance = 0;
                $maintenanceActive = PdoGsb::modifMaintenance($maintenance);
                include("index.php?uc=maintenance&action=selectmaintenance");
            }
            else if($m == $n){
                $maintenance = 1;
                $maintenanceActive = PdoGsb::modifMaintenance($maintenance);
                include("vues/v_parametre.php");
            }
            
		
		break;
	}
		

	default :{
		include("vues/v_maintenance.php");
		break;
	}
        
        
}
?>