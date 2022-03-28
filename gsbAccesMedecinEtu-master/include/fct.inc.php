<?php
//on insère le fichier qui contient les fonctions


 /**
 * Teste si un quelconque visiteur est connecté
 * @return vrai ou faux 
 */
function estConnecte(){
  return isset($_SESSION['id']);
}
/**
 * Enregistre dans une variable session les infos d'un visiteur
 
 * @param $id 
 * @param $nom
 * @param $prenom
 */
function connecter($id,$nom,$prenom){
	$_SESSION['id']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
}


/* gestion des erreurs*/
/**
 * Indique si une valeur est un entier positif ou nul
 
 * @param $valeur
 * @return vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 
 * @param $tabEntiers : le tableau
 * @return vrai ou faux
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	if (isset($unEntier) ){
		foreach($tabEntiers as $unEntier){
			if(!estEntierPositif($unEntier)){
		 		$ok=false; 
			}
		}	
	}
	return $ok;
}

/**
 * Ajoute le libellé d'une erreur au tableau des erreurs 
 
 * @param $msg : le libellé de l'erreur 
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Retoune le nombre de lignes du tableau des erreurs 
 
 * @return le nombre d'erreurs
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}


function input_data($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;

}


    
    function generateCode(){
          // Generate a 6 digits hexadecimal number
	  $numbytes = 3; // Because 6 digits hexadecimal = 3 bytes
	  $bytes = openssl_random_pseudo_bytes($numbytes); 
          $hex   = bin2hex($bytes);
	  return $hex;
        
    }
    
    function verif2Strings(string $chaine1, string $chaine2):bool {//Fonction qui vérifie que les deux chaînes de caractère sont similaires
        $verification = false;
    
         if ($chaine1==$chaine2)
                $verification = true;
    
         return $verification;
        }
    
        function verifSecuPWP($lePWD):  bool {//Fonction qui vérifie la sécurité du mdp
        $message=false;     
         $patternPassword='#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W){12,}#';
                            
            if (preg_match($patternPassword, $lePWD)==false){
                echo 'Le mot de passe doit contenir au moins 12 caractères, une majuscule,'
                . ' une minuscule et un caractère spécial<br/>';
                $message=false;
            }
            else{
                $message=true;
        
            
        }
        return $message;
            }
    
    
?>