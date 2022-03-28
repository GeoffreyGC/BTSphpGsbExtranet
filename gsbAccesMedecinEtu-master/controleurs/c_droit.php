<?php
$action = $_GET['action'];
switch($action){
	
	case 'demandeModification':{
            if ($_SESSION['id'] == 1){
            include("vues/admin/v_modificationCompte.php");            
            }else{
                include("vues/user/v_modificationCompte_Utili.php"); 
            }
		break;
}
        case 'modification':{
            $nom=$_POST['nom'];
            $prenom=$_POST['prenom'];
            $id=$_SESSION['id'];
            $mdp= htmlspecialchars($_POST['Modifmdp1']);
            $mdp2= htmlspecialchars($_POST['Modifmdp2']);
            $pdo= PdoGsb::getPdoGsb();
            $rempli=false;            
            if (empty($mdp)==true && empty($mdp2)==true){
                $modifSansMdp=$pdo->modifNomPrenom($nom,$prenom,$id);
                $message="<h3 class='text-center'>Modification effectuée !</h3>";
                echo $message;
                        
            $rempli=false; }
            else{
                if(verif2Strings($mdp, $mdp2)==true){
                    if(verifSecuPWP($mdp)){
                        $modifAvecMdp=$pdo->modifNomPrenomMdp($nom,$prenom,$mdp,$id);
                        $message="<h3 class='text-center'>Modification effectuée !</h3>";
                        echo $message;
                    }

                }
                else{
                    echo 'Les mots de passes ne sont pas similaires !';
                }
            }
        
                
            
            
                        break;
        }
        
        case 'parametre':{
            if ($_SESSION['id'] == 1){
            include("vues/admin/v_parametreCompte.php");            
            }else{
                include("vues/user/v_parametreCompte_Utili.php"); 
            }
		break;
}
case 'supprimerCompte':{
            
                include("vues/user/v_supprimerCompte_Utili.php"); 
            
		break;
}
case 'supprimer':{
            
                include("vues/user/v_supprimer_Utili.php"); 
            
		break;
}
case 'archiver':{
            
                include("vues/user/v_archiver_Utili.php"); 
            
		break;
}
case 'supprimerOK':{
            
                $pdo= PdoGsb::getPdoGsb();
                
                $id = $_SESSION['id'];
                $sup = PdoGsb::supprimerCompte($id);
                
                header('Location: index.php?uc=connexion&action=demandeDeconnexion');
            
		break;
}

case 'archiverOK':{
            
                $pdo= PdoGsb::getPdoGsb();
                
                $id = $_SESSION['id'];
                
                $tabM = PdoGsb::RecupMedecinàArchiver($id);
                $tabH = PdoGsb::RecupHistoriqueàArchiver($id);
                $tabP = PdoGsb::RecupProduitàArchiver($id);
                $tabV = PdoGsb::RecupVisioàArchiver($id);
                
                
//                var_dump($tabV);
//                var_dump($tabP);
//                var_dump($tabH);
//                var_dump($tabM);
               
               
                    $dateNaiss = $tabM['dateNaissance'];
                    $dateCrea = $tabM['dateCreation'];
      
                
                    echo $dateCrea;
                    echo $dateNaiss;
                $idM = PdoGsb::AjouteMedecinArchive($dateNaiss, $dateCrea);
                
                
                foreach ($tabH as $medecin){
                    $dateDebutLog = $medecin['dateDebutLog'];
                    $dateFinLog = $medecin['dateFinLog'];
                    
                    PdoGsb::ajouteArchiveHistoriqueCo($idM,$dateDebutLog, $dateFinLog);
                }
                
                
                foreach ($tabP as $medecin){
                    $dateP = $medecin['Date'];
                    $heurP = $medecin['Heure'];
                    $idProduit = $medecin['idProduit'];
                    
                    PdoGsb::ajouteArchiveProduit($idM,$idProduit, $dateP, $heurP);
                }
              
                foreach ($tabV as $medecin){
                    $dateInscriptionV = $medecin['dateInscription'];   
                    $idVisio = $medecin['idVisio'];
                    
                    PdoGsb::ajouteArchiveVisio($idM,$idVisio, $dateInscriptionV);
                }
                
               $sup = PdoGsb::supprimerCompte($id);
                
               header('Location: index.php?uc=connexion&action=demandeDeconnexion');
            
		break;
}
case 'cookieAccepter':{
            setcookie ("CookieAccepter","Accepter",time()+15778800);
            
            include("vues/v_connexion.php");
            $_SESSION["showcookie"]= false;
		break;
}
case 'cookieRefuser':{
            setcookie ("CookieRefuser","Refuser");
            
            include("vues/v_connexion.php");
            $_SESSION["showcookie"]=false;
		break;
}

case 'recupererDonneePersonnelle':{
        
    $id = $_SESSION['id'];
    $nom;
    $prenom;
    $mail;
    $dateNaissance;
    $dateDiplome;
    $rpps;
    $dateConsentement;
    $tab = PdoGsb::recupInfo($id);
    
    foreach ($tab as $info){
        $nom = $info['nom'];
        $prenom = $info['prenom'];
        $mail = $info['mail'];
        $dateNaissance = $info['dateNaissance'];
        $dateDiplome = $info['dateDiplome'];
        $rpps = $info['rpps'];
        $dateConsentement = $info['dateConsentement'];
        
        PdoGsb::json($nom, $prenom, $mail, $dateNaissance, $dateDiplome, $rpps, $dateConsentement);
        
        $file = 'css/mesInfos.txt'; 
        
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="'.basename($file).'"');
        echo readfile($file);
        
       if(file_exists($file)){unlink($file);}
       
       
    }
    
    
		break;
}

}
        ?>