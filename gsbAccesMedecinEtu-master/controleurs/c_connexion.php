<?php


if(!isset($_GET['action'])){
	$_GET['action'] = 'demandeConnexion';
}
$action = $_GET['action'];
switch($action){
	
	case 'demandeConnexion':{
		include("vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
            
		$login = PdoGsb::hashMail($_POST['login']);
		$mdp = $_POST['mdp'];
		$connexionOk = $pdo->checkUser($login,$mdp);
                
                
		if(!$connexionOk){
			ajouterErreur("Login ou mot de passe incorrect");
			include("vues/v_erreurs.php");
			include("vues/v_connexion.php");
		}
		else { 
                    if(isset($_COOKIE['CookieAccepter']) || isset($_COOKIE['CookieRefuser'])){
                        $infosMedecin = $pdo->donneLeMedecinByMail($login);
			$id = $infosMedecin['id'];
			$nom =  $infosMedecin['nom'];
			$prenom = $infosMedecin['prenom'];
			connecter($id,$nom,$prenom);
                        $connection = PdoGsb::ajouteConnexion($id);
                        if ($id == 1){                                
                            include("vues/admin/v_sommaire.php");                        
                        }else{
                            include("vues/user/v_sommaire_Utili.php");}
                    }else{
                $message = "<h1 class='text-center' style='color: red;'>Veuillez accepter ou refuser l'utilisation des cookie</h1>";
                echo $message;
                include("vues/v_connexion.php");
            }}
                
            }

			break;	
	
        
        case 'demandeDeconnexion':{
            
            $id = $_SESSION['id'];
            
            $deco = PdoGsb::ajouteDeconnexion($id);
            
            $heure2 = strtotime(date("h:i:s"), time());
            $heureCookie = strtotime($_COOKIE['CookieSession']);
            
            $tempRester = $heure2 - $heureCookie;
            
            $message = "<h1 style='color:blue'>Vous êtes resté(e) ".$tempRester." seconde(s) sur notre site <br> Merci de votre visite !! </h1>";
            echo $message;
            setcookie('CookieSession');
		include("vues/v_connexion.php");
		break;
	}
       
        
	default :{
		include("vues/v_connexion.php");
		break;
	}
}
?>