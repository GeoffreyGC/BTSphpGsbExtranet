<?php
$action = $_GET['action'];
switch($action){
	
	case 'demandeVisio':{
		include("vues/admin/v_visio.php");
		break;
            
        }
        case 'GererVisio':{
            include("vues/admin/v_gererVisio.php");
            break;
        }
        
        case 'creationvisio':{
            include("vues/admin/v_creationVisio.php");
            break;
        }
        case 'creationOk':{
            
            $pdo = PdoGsb::getPdoGsb();
            $estConnecte= estConnecte();
            //var_dump($_GET);
            $nom=htmlspecialchars($_POST['nomVisio']);
            $objectif=htmlspecialchars($_POST['objectifVisio']);
            $url=htmlspecialchars($_POST['urlVisio']);
            $date=htmlspecialchars($_POST['dateVisio']);
            $nbCarMaxNom=$pdo->tailleChampsNom();
            $nbCarMaxObjectif=$pdo->tailleChampsObjectif();
            $nbCarMaxUrl=$pdo->tailleChampsUrl();
            if(strlen($objectif)<$nbCarMaxObjectif && strlen($url)<$nbCarMaxUrl && strlen($nom)<$nbCarMaxNom){
                if (!empty($nom)==true && !empty($objectif)==true && !empty($url)==true && !empty($date)==true){
                    if($nom==$_POST['nomVisio'] && $objectif==$_POST['objectifVisio'] && $url==$_POST['urlVisio']){
                        $ajoutVisio= PdoGsb::ajouteVisio($nom, $objectif, $url, $date);
                        $message="<h3 class='text-center'>L'ajout à été fais avec succès</h3>";
                        echo $message;
                        include("vues/admin/v_creationVisio.php");}
                     else{
                        $message="<h3 class='text-center'>tentative d\'injection javascript - ajout refusé'</h3>";
                        echo $message;
                        include("vues/admin/v_creationVisio.php");
                         
                    }}
                     
                else{
                    $message="<h3 class='text-center'>Veuillez remplir tous les champs !</h3>";
                    echo $message;
                    include("vues/admin/v_creationVisio.php");
                }}
            else{
                $message="<h3 class='text-center'>La taille des informations est trop importantes !</h3>";
                echo $message;
                include("vues/admin/v_creationVisio.php");
            }
            break;
        }
        
        case 'detailsVisio':{
            if ($_SESSION['id'] == 1)
                include("vues/admin/v_detailsVisio.php");
            else
                include("vues/user/v_detailsVisio_Utili.php");
            break;
        }
        
        case 'modifVisio':{
            include("vues/admin/v_modifVisio.php");
            break;
        }
        
        case 'ConfirmeModifVisio':{
           
            $pdo = PdoGsb::getPdoGsb();
            $estConnecte= estConnecte();
            $id=$_GET['id'];
            //var_dump($_GET);
            $nom=htmlspecialchars($_POST['ModifNomVisio']);
            $objectif=htmlspecialchars($_POST['ModifObjectif']);
            $url=htmlspecialchars($_POST['ModifURL']);
            $date=htmlspecialchars($_POST['ModifDate']);
            $nbCarMaxNom=$pdo->tailleChampsNom();
            $nbCarMaxObjectif=$pdo->tailleChampsObjectif();
            $nbCarMaxUrl=$pdo->tailleChampsUrl();
            if(strlen($objectif)<$nbCarMaxObjectif && strlen($url)<$nbCarMaxUrl && strlen($nom)<$nbCarMaxNom){
                if (!empty($nom)==true && !empty($objectif)==true && !empty($url)==true && !empty($date)==true){
                    if($nom==$_POST['ModifNomVisio'] && $objectif==$_POST['ModifObjectif'] && $url==$_POST['ModifURL']){
                        $ajoutVisio= PdoGsb::modifVisio($nom, $objectif, $url, $date,$id);
                        $message="<h3 class='text-center'>Modification faites avec succès</h3>";
                        echo $message;
                        include("vues/admin/v_modifVisio.php");}
                    else{
                        $message="<h3 class='text-center'>tentative d\'injection javascript - ajout refusé'</h3>";
                        echo $message;
                        include("vues/admin/v_creationVisio.php");}}
                else{
                    $message="<h3 class='text-center'>Veuillez remplir tous les champs !</h3>";
                    echo $message;
                    include("vues/admin/v_modifVisio.php");
            }}
            else{
                $message="<h3 class='text-center'>La taille des informations est trop importantes !</h3>";
                echo $message;
                include("vues/admin/v_modifVisio.php");
            }
            break;
        }
        
        case 'supprimer':{
        
            include("vues/admin/v_supprimerVisio.php");
            break;
        }
        
        case 'suppr':{
            $pdo= PdoGsb::getPdoGsb();
            $estConnecte= estConnecte();
            $id=$_GET['id'];
            $supprimer= PdoGsb::supprimerVisio($id);
            $message="<h3 class='text-center'>Visio supprimer avec succès !</h3>";
            echo $message;
            include("vues/admin/v_visio.php");
            break;
        }
        
        case 'inscriptionVisio':{
            if ($_SESSION['id'] == 1)
            include('vues/admin/v_inscriptionVisio.php');
            else
                include('vues/user/v_inscriptionVisio_Utili.php');
            break;
        }
        
    
   
}
        ?>