<?php

/** 
 * Classe d'accÃ¨s aux donnÃ©es. 
 
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 
 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{   		
      	private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsb';   		
      	private static $user='root' ;    		
      	private static $mdp='' ;	
	private static $monPdo;
	private static $monPdoGsb=null;
		
/**
 * Constructeur privÃ©, crÃ©e l'instance de PDO qui sera sollicitÃ©e
 * pour toutes les mÃ©thodes de la classe
 */				
	private function __construct(){
          
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp); 
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}
/**
 * Fonction statique qui crÃ©e l'unique instance de la classe
 
 * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
 
 * @return l'unique objet de la classe PdoGsb
 */
	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;  
	}
/**
 * vÃ©rifie si le login et le mot de passe sont corrects
 * renvoie true si les 2 sont corrects
 * @param type $lePDO
 * @param type $login
 * @param type $pwd
 * @return bool
 * @throws Exception
 */

function hashPWD($pwd): string{
    return password_hash($pwd, PASSWORD_DEFAULT);
}

public static function recupKey(){
    
    $fichier = file("css/dora.txt");
    $total=count($fichier);
    for($i=0; $i<$total; $i++){
        $key=$fichier[$i];
    }
    return $key;
    
}


public static function recupNonce(){
    $fichier=file("css/Oui-Oui-Nounce.txt");
    $total=count($fichier);
    for($i=0; $i<$total; $i++){
        $nonce=$fichier[$i];
    }
    return $nonce;
}

public static function hashMail($mail){
    $key= PdoGsb::recupKey();
    $nonce= PdoGsb::recupNonce();
    $encrypted = sodium_crypto_secretbox($mail, $nonce, $key);
    return $encrypted;
}

public static function decrypteMail($mail){
    $key= PdoGsb::recupKey();
    $nonce= PdoGsb::recupNonce();
    $deencrypted = sodium_crypto_secretbox_open($mail, $nonce, $key);
    return $deencrypted;
}

function checkUser($login,$pwd):bool {
    //AJOUTER TEST SUR TOKEN POUR ACTIVATION DU COMPTE
    $user=false;
    $pdo = PdoGsb::$monPdo;
    
    $monObjPdoStatement=$pdo->prepare("SELECT motDePasse FROM medecin WHERE mail= :login AND token IS NULL");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
        if (is_array($unUser)){
           if(count($unUser)!=1){
           if (password_verify($pwd,$unUser['motDePasse']))
                
                $user=true;
        }
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $user;   
}}


	

function donneLeMedecinByMail($login) {
    
    $pdo = PdoGsb::$monPdo;
    $monObjPdoStatement=$pdo->prepare("SELECT id, nom, prenom,mail FROM medecin WHERE mail= :login");
    $bvc1=$monObjPdoStatement->bindValue(':login',$login,PDO::PARAM_STR);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
       
    }
    else
        throw new Exception("erreur dans la requÃªte");
return $unUser;   
}


public function tailleChampsMail(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'medecin' AND COLUMN_NAME = 'mail'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}

public function tailleChampsNom(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'visioconference' AND COLUMN_NAME = 'nomVisio'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}

public function tailleChampsObjectif(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'visioconference' AND COLUMN_NAME = 'objectif'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}

public function tailleChampsUrl(){
    

    
     $pdoStatement = PdoGsb::$monPdo->prepare("SELECT CHARACTER_MAXIMUM_LENGTH FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = 'visioconference' AND COLUMN_NAME = 'url'");
    $execution = $pdoStatement->execute();
$leResultat = $pdoStatement->fetch();
      
      return $leResultat[0];
    
       
       
}

public function creeMedecin($nom,$prenom,$email, $mdp,$naiss)
{
    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
    
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO medecin(id,nom,prenom,mail,dateNaissance,motDePasse,dateCreation,dateConsentement) "
            . "VALUES (null, :leNom,:lePrenom ,:leMail,:naiss, :leMdp, now(),now())");
    $bv1 = $pdoStatement->bindValue(':leMail', self::hashMail($email)); 
    $bv2 = $pdoStatement->bindValue(':leMdp', $mdpHash);
    $bv3 = $pdoStatement->bindValue(':leNom', $nom);
    $bv4 = $pdoStatement->bindValue(':lePrenom', $prenom);
    $bv5 = $pdoStatement->bindValue(':naiss', $naiss);
    $execution = $pdoStatement->execute();
    return $execution;
    
}


function testMail($email){
    $pdo = PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("SELECT count(*) as nbMail FROM medecin WHERE mail = :leMail");
    $bv1 = $pdoStatement->bindValue(':leMail', $email);
    $execution = $pdoStatement->execute();
    $resultatRequete = $pdoStatement->fetch();
    if ($resultatRequete['nbMail']==0)
        $mailTrouve = false;
    else
        $mailTrouve=true;
    
    return $mailTrouve;
}

public static function modifNomPrenom($nom,$prenom,$id){
    $pdo= PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("UPDATE medecin SET nom=:leNom, prenom=:lePrenom WHERE id=:id");
    $bv1=$pdoStatement->bindValue(":leNom",$nom);
    $bv2=$pdoStatement->bindValue(":lePrenom",$prenom);
     $bv3=$pdoStatement->bindValue(":id",$id);
    $executionOk=$pdoStatement->execute();
    $resultatRequete=$pdoStatement->fetch();
    return $executionOk;
    
}

public static function modifNomPrenomMdp($nom,$prenom,$mdp,$id){
    $pdo= PdoGsb::$monPdo;
    $mdpHash = password_hash($mdp, PASSWORD_DEFAULT);
    $pdoStatement = $pdo->prepare("UPDATE medecin SET nom=:leNom, prenom=:lePrenom,motDePasse=:leMdp WHERE id=:id");
    $bv1=$pdoStatement->bindValue(":leNom",$nom);
    $bv2=$pdoStatement->bindValue(":lePrenom",$prenom);
    $bv3=$pdoStatement->bindValue(":leMdp",$mdpHash);
    $bv4=$pdoStatement->bindValue(":id",$id);
    $executionOk=$pdoStatement->execute();
    $resultatRequete=$pdoStatement->fetch();
    return $executionOk;
   
}




function connexionInitiale($mail){
     $pdo = PdoGsb::$monPdo;
    $medecin= $this->donneLeMedecinByMail($mail);
    $id = $medecin['id'];
    $this->ajouteConnexionInitiale($id);
    
}

function ajouteConnexionInitiale($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion "
            . "VALUES (:leMedecin, now(), now())");
    $bv1 = $pdoStatement->bindValue(':leMedecin', $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

public static function ajouteConnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("INSERT INTO historiqueconnexion(idMedecin ,dateDebutLog,dateFinLog) VALUES (?, now(), null)");    
    $bv2 = $pdoStatement->bindValue(1, $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

public static function ajouteDeconnexion($id){
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE historiqueconnexion SET dateFinLog = now() WHERE dateFinLog IS NULL AND idMedecin = ?");    
    $bv2 = $pdoStatement->bindValue(1, $id);
    $execution = $pdoStatement->execute();
    return $execution;
    
}

function donneinfosmedecin($id){
  
       $pdo = PdoGsb::$monPdo;
           $monObjPdoStatement=$pdo->prepare("SELECT id,nom,prenom FROM medecin WHERE id= :lId");
    $bvc1=$monObjPdoStatement->bindValue(':lId',$id,PDO::PARAM_INT);
    if ($monObjPdoStatement->execute()) {
        $unUser=$monObjPdoStatement->fetch();
   
    }
    else
        throw new Exception("erreur");
           
    
}

public function modifMail($nouveaumail){
    $id=$_POST['idCache'];
    $pdoStatement = PdoGsb::$monPdo->prepare("UPDATE medecin SET mail=':leMail' WHERE id=$id"); 
    $bv1 = $pdoStatement->bindValue(':leMail', $nouveaumail);
    $execution = $pdoStatement->execute();
    return $execution;
}

public static function listeVisio(){
    $pdo = PdoGsb::$monPdo;
    
    $sql=("SELECT * FROM visioconference");
    $requete=$pdo->prepare($sql);
    $executionOk=$requete->execute();
    $tab=$requete->fetchAll();
    $requete->closeCursor();
    return $tab;
//    while($tab=$requete->fetch(PDO::FETCH_ASSOC)){
//        echo($tab['nomVisio'])." |";
//        echo($tab['objectif'])." |";
//        echo($tab['url'])." |";
//        echo($tab['dateVisio']),'<br/>'.'<br/>';
//        echo("-----------------------------------------------------------------"
//                . "------------------------------------------------------------"
//                . "----------------------").'<br/>'.'<br/>';
//    }
}

public static function listeVisio2($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql=("SELECT * FROM visioconference WHERE id=:lID");
    $requete=$pdo->prepare($sql);
    $bv1=$requete->bindValue(':lID',$id);
    $executionOk=$requete->execute();
    $tab=$requete->fetchAll();
    $requete->closeCursor();
    return $tab;
//    while($tab=$requete->fetch(PDO::FETCH_ASSOC)){
//        echo($tab['nomVisio'])." |";
//        echo($tab['objectif'])." |";
//        echo($tab['url'])." |";
//        echo($tab['dateVisio']),'<br/>'.'<br/>';
//        echo("-----------------------------------------------------------------"
//                . "------------------------------------------------------------"
//                . "----------------------").'<br/>'.'<br/>';
//    }
}

public static function etatServeur(){
    $pdo = PdoGsb::$monPdo;
    $co;
    $sql = 'SELECT * FROM maintenance';
    $requete = $pdo->prepare($sql);
    $executionOk = $requete->execute();
    
    while ($tab = $requete->fetch(PDO::FETCH_ASSOC)){   
        if ($tab['Etat'] == 1){
        $co = 1;
    }else if ($tab['Etat'] == 0){
        $co = 0;
    }
    }
    
    return $co;
    
}

public static function ajouteVisio($nom,$objectif,$url,$date) {
    
    $pdo = PdoGsb::$monPdo;
    //var_dump($pdo);
    $requete = $pdo->prepare("INSERT INTO visioconference(id,nomVisio,objectif,url,dateVisio) VALUES(null, :leNom, :lObjectif,:lUrl,:laDate)");
    $bv1 = $requete->bindValue(':leNom',$nom,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(':lObjectif', $objectif,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(':lUrl', $url,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(':laDate', $date);
    $executionok = $requete->execute();
    return $executionok;



}
public static function modifVisio($nom,$objectif,$url,$date,$id){
    $pdo= PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("UPDATE visioconference SET nomVisio=:leNom , objectif=:lObjectif , url=:lUrl , dateVisio=:laDate WHERE id=:id");
    $bv1=$pdoStatement->bindValue(":leNom",$nom, PDO::PARAM_STR);
    $bv2=$pdoStatement->bindValue(":lObjectif",$objectif, PDO::PARAM_STR);
    $bv3=$pdoStatement->bindValue(":lUrl",$url, PDO::PARAM_STR);
    $bv4=$pdoStatement->bindValue(":laDate",$date,PDO::PARAM_STR);
    $bv5=$pdoStatement->bindValue(":id",$id);
    $executionOk=$pdoStatement->execute();
    $resultatRequete=$pdoStatement->fetch();
   return $executionOk;
}

public static function supprimerVisio($id){
    $pdo= PdoGsb::$monPdo;
    $pdoStatement = $pdo->prepare("DELETE FROM visioconference WHERE id=:id");
    $bv1=$pdoStatement->bindValue(":id",$id);
    $executionOk=$pdoStatement->execute();
return $executionOk;
}

public static function modifMaintenance($m){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "UPDATE maintenance SET Etat = ?";
    
    $rs_modif = $pdo->prepare($sql);

    $rs_modif->bindValue(1,$m);
    
    $executionOk= $rs_modif->execute();
 return $executionOk;
}

public static function listeProduit(){
    $pdo = PdoGsb::$monPdo;
    
    $sql = 'SELECT * FROM produit';
    $requete = $pdo->prepare($sql);
    $executionOk = $requete->execute();
    
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    
    
//    while ($tab = $requete->fetch(PDO::FETCH_ASSOC)){   
//        echo $tab['nom'].', ';
//        echo $tab['objectif'].', ';
//        echo $tab['information'].', ';
//        echo $tab['effetIndesirable'],'<br>','<br>';
    
    return $tab;
    
    
}

public static function listeProduitV2($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT * FROM produit WHERE id = '{$id}'";
    $requete = $pdo->prepare($sql);
    $executionOk = $requete->execute();
    
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    
    
//    while ($tab = $requete->fetch(PDO::FETCH_ASSOC)){   
//        echo $tab['nom'].', ';
//        echo $tab['objectif'].', ';
//        echo $tab['information'].', ';
//        echo $tab['effetIndesirable'],'<br>','<br>';
    
    return $tab;
    
    
}
public static function modifProduit($id,$nom,$objectif,$info,$effet){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "UPDATE produit SET nom = ?, objectif = ?, information = ?, effetIndesirable = ? WHERE Id  = '{$id}'";
    
    $rs_modif = $pdo->prepare($sql);

    $rs_modif->bindValue(1,$nom,PDO::PARAM_STR);
    $rs_modif->bindValue(2,$objectif,PDO::PARAM_STR);
    $rs_modif->bindValue(3,$info,PDO::PARAM_STR);
    $rs_modif->bindValue(4,$effet,PDO::PARAM_STR);
    
    $executionOk= $rs_modif->execute();
 return $executionOk;
}

public static function suppProduit($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "DELETE FROM produit WHERE Id  = '{$id}'";    
    $rs_modif = $pdo->prepare($sql);
    $executionOk= $rs_modif->execute();
 return $executionOk;
}

public static function AjouteProduit($nom,$obj,$info,$effet){
    $pdo = PdoGsb::$monPdo;
    
    $requete = $pdo->prepare("INSERT INTO produit(nom,objectif,information,effetIndesirable) VALUES (?,?,?,?)");
    
    $bv1 = $requete->bindValue(1,$nom,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(2,$obj,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(3,$info,PDO::PARAM_STR);
    $bv4 = $requete->bindValue(4,$effet,PDO::PARAM_STR);
    $executionok = $requete->execute();
 return $executionok;
}

public static function supprimerCompte($id){
    $pdo = PdoGsb::$monPdo;
    
   
     $requete2 = $pdo->prepare("DELETE FROM historiqueconnexion WHERE idMedecin = ?");
     $bv2 = $requete2->bindValue(1,$id,PDO::PARAM_STR);
     $executionok2 = $requete2->execute();
     
     $requete3 = $pdo->prepare("DELETE FROM medecinproduit WHERE idMedecin = ?");
     $bv3 = $requete3->bindValue(1,$id,PDO::PARAM_STR);
     $executionok3 = $requete3->execute();
     
     $requete4 = $pdo->prepare("DELETE FROM medecinvisio WHERE idMedecin = ?");
     $bv4 = $requete4->bindValue(1,$id,PDO::PARAM_STR);
     $executionok4 = $requete4->execute();
     
     $requete1 = $pdo->prepare("DELETE FROM medecin WHERE id = ?");
     $bv1 = $requete1->bindValue(1,$id,PDO::PARAM_STR);
     $executionok1 = $requete1->execute();
     
     return $executionok1 && $executionok2 && $executionok3 && $executionok4;
}

public static function RecupMedecinàArchiver($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT id,dateNaissance,dateCreation FROM medecin WHERE id = ?";
    $requete = $pdo->prepare($sql);
    $bvc1 = $requete->bindValue(1,$id);
    $executionOK = $requete->execute();
    
    $tab = $requete->fetch();
    $requete->closeCursor();
    
    return $tab;
}
public static function RecupProduitàArchiver($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT idMedecin,idProduit,Date,Heure  FROM medecinproduit WHERE idMedecin = ?";
    $requete = $pdo->prepare($sql);
    $bvc1 = $requete->bindValue(1,$id);
    $executionOK = $requete->execute();
    
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    return $tab;
}
public static function RecupVisioàArchiver($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT idMedecin,idVisio,dateInscription  FROM medecinvisio WHERE idMedecin = ?";
    $requete = $pdo->prepare($sql);
    $bvc1 = $requete->bindValue(1,$id);
    $executionOK = $requete->execute();
    
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    return $tab;
}
public static function RecupHistoriqueàArchiver($id){
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT idMedecin,dateDebutLog,dateFinLog FROM historiqueconnexion WHERE idMedecin = ?";
    $requete = $pdo->prepare($sql);
    $bvc1 = $requete->bindValue(1,$id);
    $executionOK = $requete->execute();
    
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    
    return $tab;
}

public static function AjouteMedecinArchive($dateNaiss,$crea){
    $pdo = PdoGsb::$monPdo;
    
    $requete = $pdo->prepare("INSERT INTO medecinarchive(dateNaiss,dateCreationCompte) VALUES (?,?)");
    
    
    $bv1 = $requete->bindValue(1,$dateNaiss,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(2,$crea,PDO::PARAM_STR);
    
    $requete->execute();
    
    $id=$pdo->lastInsertId();
    return $id;
 
}

public static function ajouteArchiveProduit($id,$idproduit,$date,$heure){
    $pdo = PdoGsb::$monPdo;
    
//    $sqlIdM = "SELECT MAX(idMedecin) FROM medecinarchive";
//    $valeur= $pdo->prepare($sqlIdM);
//    $valeur->execute();
    
    $sql = "INSERT INTO medecinproduitarchive VALUES (?,?,?,?)";
    $requete= $pdo->prepare($sql);
    
    $bv1 = $requete->bindValue(1,$id,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(2,$idproduit,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(3,$date,PDO::PARAM_STR);
    $bv4 = $requete->bindValue(4,$heure,PDO::PARAM_STR);
    
    $executionok = $requete->execute();
 return $executionok;
}

public static function ajouteArchiveVisio($id,$idvisio,$dateInscription){
    $pdo = PdoGsb::$monPdo;
    
//    $sqlIdM = "SELECT MAX(idMedecin) FROM medecinarchive";
//    $valeur= $pdo->prepare($sqlIdM);
//    $valeur->execute();
    
    $sql = "INSERT INTO medecinvisioarchive VALUES (?,?,?)";
    $requete= $pdo->prepare($sql);
    
    $bv1 = $requete->bindValue(1,$id,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(2,$idvisio,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(3,$dateInscription,PDO::PARAM_STR);

    
    $executionok = $requete->execute();
 return $executionok;
}

public static function ajouteArchiveHistoriqueCo($id,$dateDebut,$dateFin){
    $pdo = PdoGsb::$monPdo;
    
//    $sqlIdM = "SELECT MAX(idMedecin) FROM medecinarchive";
//    $valeur= $pdo->prepare($sqlIdM);
//    $valeur->execute();
    
    $sql = "INSERT INTO historiqueconnexionarchive VALUES (?,?,?)";
    $requete= $pdo->prepare($sql);
    
    $bv1 = $requete->bindValue(1,$id,PDO::PARAM_STR);
    $bv2 = $requete->bindValue(2,$dateDebut,PDO::PARAM_STR);
    $bv3 = $requete->bindValue(3,$dateFin,PDO::PARAM_STR);

    
    $executionok = $requete->execute();
 return $executionok;
}

public static function recupInfo($id) {
    $pdo = PdoGsb::$monPdo;
    
    $sql = "SELECT nom,prenom,mail,dateNaissance,dateDiplome,rpps,dateConsentement FROM medecin WHERE id = ?";
    $requete=$pdo->prepare($sql);
    
    $bv1 = $requete->bindValue(1,$id);
    
    $executionok = $requete->execute();
    $tab = $requete->fetchAll();
    $requete->closeCursor();
    
    
    return $tab;
}

public static function json($nom,$prenom,$mail,$dateNaissance,$dateDiplome,$rpps,$dateConsentement) {
    $file='css/mesInfos.txt';
    
    $json = json_encode(["nom" => $nom,"prenom" => $prenom,"mail" => $mail,"dateNaissance" => $dateNaissance,"dateDiplome" => $dateDiplome,"rpps" => $rpps,"dateConsentement" => $dateConsentement]);
    $fichier = file_put_contents($file, $json,FILE_APPEND | LOCK_EX);
    return $fichier;
}
}
?>