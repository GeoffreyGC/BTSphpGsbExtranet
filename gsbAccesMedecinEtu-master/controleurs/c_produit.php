<?php

if(!isset($_GET['action'])){
	$_GET['action'] = 'selectProduit';
}
$action = $_GET['action'];
switch($action){
	
	case 'selectProduit':{
		include("vues/admin/v_produit.php");
		break;
	}
        
        case 'ajouterProd':{
		include("vues/admin/v_ajouteproduit.php");
		break;
	}
        
        case 'ajouterP':{
            
                $pdo = PdoGsb::getPdoGsb();
                $estConnecte = estConnecte();
                
                $n = $_POST['nom'];
                $o = $_POST['objectif'];
                $i = $_POST['info'];
                $e = $_POST['effet'];
                
                $ajoute = PdoGsb::AjouteProduit($n, $o, $i, $e);
                
                $message = "<h3 class='text-green text-center'>Produit ajouté</h3>";
                echo $message;
            
		include("vues/admin/v_ajouteproduit.php");
		break;
	}
        
        case 'detailP':{
		include("vues/admin/v_detailproduit.php");
		break;
	}
        
        case 'detailPUtili':{
            
		include("vues/user/v_produit_Utili.php");
		break;
	}
        
         case 'detailProduitUtili':{
            
		include("vues/user/v_detailproduit_Utili.php");
		break;
	}
        
        case 'modifP':{
		include("vues/admin/v_modificationproduit.php");
		break;
	}
        
        case 'modification':{
            
            $i = $_GET['id'];
            $n = $_POST['nom'];
            $o = $_POST['objectif'];
            $info = $_POST['info'];
            $e = $_POST['effet'];
            
           
            $message = "<h6 class='text-center'>Produit modifié</h6>";
            echo $message;
            
            $modif = PdoGsb::modifProduit($i, $n, $o, $info, $e);
		include("vues/admin/v_modificationproduit.php");
		break;
	}

        case 'supprimer':{
		include("vues/admin/v_suppProduit.php");
		break;
	}
        
        case 'supp':{
            
            $id = $_GET['id'];
            
            $supp = PdoGsb::suppProduit($id);
            $message = "<h6 class='text-center'>Produit Supprimé</h6>";
            echo $message;
            
		include("vues/admin/v_produit.php");
		break;
	}
        default :{
		include("vues/user/v_produit.php");
		break;
	}
}
