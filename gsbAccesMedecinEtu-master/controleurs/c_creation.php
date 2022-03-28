<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeCreation';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeCreation':{
		include("vues/v_creation.php");
		break;
	}
	case 'valideCreation':{
		
           
		$leLogin = htmlspecialchars($_POST['login']);
                $lePassword = htmlspecialchars($_POST['mdp']);
                $leNom = htmlspecialchars($_POST['nom']);
                $lePrenom = htmlspecialchars($_POST['prenom']);
                $naissance = htmlspecialchars($_POST['naiss']);
        
        
        
        if ($leLogin == $_POST['login'])
        {
             $loginOk = true;
             $passwordOk=true;
             $naissOK = true;
        }
        else{
            echo 'tentative d\'injection javascript - login refusé';
             $loginOk = false;
             $passwordOk=false;
             $naissOK = false;
        }
        //test récup données
        //echo $leLogin.' '.$lePassword;
        $rempli=false;
        if ($loginOk && $passwordOk){
        //obliger l'utilisateur à saisir login/mdp
        $rempli=true; 
        if (empty($leLogin)==true) {
            echo 'Le login n\'a pas été saisi<br/>';
            $rempli=false;
        }
        if (empty($lePassword)==true){
            echo 'Le mot de passe n\'a pas été saisi<br/>';
            $rempli=false; 
        }

        //si le login et le mdp contiennent quelque chose
        // on continue les vérifications
        if ($rempli){
            //supprimer les espaces avant/après saisie
            $leLogin = trim($leLogin);
            $lePassword = trim($lePassword);

            

            //vérification de la taille du champs
            
            $nbCarMaxLogin = $pdo->tailleChampsMail();
            if(strlen($leLogin)>$nbCarMaxLogin){
                 echo 'Le login ne peut contenir plus de '.$nbCarMaxLogin.'<br/>';
                $loginOk=false;
                
            }
            
            //vérification du format du login
           if (!filter_var($leLogin, FILTER_VALIDATE_EMAIL)) {
                echo 'le mail n\'a pas un format correct<br/>';
                $loginOk=false;
            }
            
          
            $patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
            if (preg_match($patternPassword, $lePassword)==false){
                echo 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
                . ' une minuscule et un caractère spécial<br/>';
                $passwordOk=false;
            }
            
            $patternNaiss='#^(?=.*[0-9])#';
            if (preg_match($patternNaiss, $naissance)==false){
                echo "L'année de naissance doit contenir que de chiffre"
                . '<br/>';
                $naissOK=false;
            }
            
            
                 
        }
        }
                $coche=false;
                if(!isset($_POST['consentement'])){
                   echo 'Veuillez cocher la case pour vous inscrire';
                    $coche=false;
        }
           else{
               $coche=true;
           }
        
        if($rempli && $loginOk && $passwordOk && $naissOK && $coche==true){
                echo 'tout est ok, nous allons pouvoir créer votre compte...<br/>';
                $executionOK = $pdo->creeMedecin($leNom,$lePrenom,$leLogin,$lePassword,$naissance);
               
                if ($executionOK==true){
                    echo "c'est bon, votre compte a bien été créé !";
                    $pdo->connexionInitiale($leLogin);
                }   
          
                    else
                     echo "ce login existe déjà, veuillez en choisir un autre";
            }

			
        
        break;	
}
	default :{
		include("vues/v_connexion.php");
		break;
	}
        
        
}
?>