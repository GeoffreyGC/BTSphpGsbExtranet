﻿<!DOCTYPE html>
<html lang="fr">
<head>
    <title>GSB -extranet</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body background="assets/img/laboratoire.jpg">

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
<nav class="navbar navbar-default">
  <div class="container-fluid">
      <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Galaxy Swiss Bourdin</a>
    </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        
        <li class="active"><a href="index.php?uc=etatFrais&action=selectionnerMois">M'inscrire à une visio</a></li>
        <li class="active"><a href="index.php?uc=visio&action=demandeVisio">Gérer une visio</a></li>
        <li class="active"><a href="index.php?uc=droit&action=parametre">Parametre compte</a></li>
        <li class="active"><a href="index.php?uc=produit&action=selectProduit">Les produits</a></li>
        <li class="active"><a href="index.php?uc=produit&action=ajouterProd">Ajouter un produit</a></li>
         
      </ul>
      <ul class="nav navbar-nav navbar-right">
		  <li><a><?php echo $_SESSION['prenom']."  ".$_SESSION['nom']?></a></li>
		  <li><a>Médecin</a></li>
                  <li class="active"><a href="index.php?uc=connexion&action=demandeDeconnexion">Deconnexion</a></li>
       
     </ul>
    </div>
  </div>
</nav>
<div class="page-content container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="login-wrapper">
				<div class="box">
						
                                    <div class="content-wrap">
						<legend>Les produits</legend>
							<?php 
                                                        $pdo = PdoGsb::getPdoGsb();
                                                        $estConnecte = estConnecte();
                                                        $id = $_GET['id'];
                                                        $tab = PdoGsb::listeProduitV2($id);
                                                        ?>
                                                        
                                                 <h6> <?php  
                                                        foreach ($tab as $produit){
                                                        
                                                        echo  'NOM '.' : '.$produit['nom'].'<br>'.'<br>';
                                                        echo  'OBJECTIF '.' : '.$produit['objectif'].'<br>'.'<br>';
                                                        echo  'INFORMATION '.' : '.$produit['information'].'<br>'.'<br>';
                                                        echo  'EFFET INDESIRABLE '.' : '.$produit['effetIndesirable'].'<br>'.'<br>';
                                                        ?>
                                                        
                                                      <?php
                                                      }?>  
                                                     <a class="btn btn-primary signup" href="index.php?uc=produit&action=modifP&id=<?php echo $produit['id']?>">Modifier</a>
                                                     
                                                     <a class="btn btn-primary signup" href="index.php?uc=produit&action=supprimer&id=<?php echo $produit['id']?>">Supprimer</a>
                                                 </h6>
                                                
                                                
                                                
                                                        
							</br>
                                                        
						
					</div>	
				</div>
			</div>
		</div>
	</div>
</div>

  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/custom.js"></script>
  </body>
</html>