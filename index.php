<?php

ob_start("ob_gzhandler");
session_start();

include("fonctions.php");
include("connexion.php");
include("accueil.php");
include("login.php");
include("artiste.php");
include("album.php");
include("recherche.php");
include("panier.php");

connexion();

function getSelectedP($param)
{
	if(isset($_REQUEST["p"]) && $_REQUEST["p"] == $param)
	{
		return ' class="selected"';
	}
	else
	{
		return '';
	}
}

function echoAll()
{
	global $racine;
	
	echo '
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<base href="'.$racine.'" />
		<link type="text/css" href="style.css" rel="stylesheet" />
		<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.20.custom.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
		<title>Catalogue d’albums de musique</title>
		<link rel="icon" type="image/png" href="img/favicon.png" />
        <link rel="shortcut icon" type="image/png" href="img/favicon.png" />
	</head>
	<body>
		<div id="main">
			<div id="entete">
				<div id="statut">'.loginStatut().'</div>
				<div id="logo">
					<a href="'.$racine.'">
						<h1> Catalogue d’albums de musiques </h1>
						<!--<img src="img/logo.jpg" alt="Logo avec lien sur page d’accueil" />-->
					</a>
				</div>
				<div id="divMenu">
					<ul id="menu">
						<li><a href="accueil"'.getSelectedP("accueil").'>Accueil</a></li>
						<li><a href="artiste"'.getSelectedP("artiste").'>Artistes</a></li> <!-- &amp;idArtiste=0 -->
						<li><a href="album"'.getSelectedP("album").'>Albums</a></li> <!-- &amp;idAlbum=0 -->
						<li><a href="login"'.getSelectedP("login").'>Connexion</a></li>
						<li><a href="?p=recherche"'.getSelectedP("recherche").'>Recherche</a></li>
						<li><a href="?p=panier"'.getSelectedP("panier").'>Panier</a></li>
					</ul>
					<!--<input type="text" id="rechercheAutocomplete" placeholder="Entrez le début d’un nom/titre/…" />-->
				</div>
			</div>';
	if(isset($_REQUEST["p"]))
	{
		switch($_REQUEST["p"])
		{
			case "album":
				echoAlbum();
				break;
			case "artiste":
				echoArtiste();
				break;
			case "recherche":
				echoRecherche();
				break;
			case "login":
				echoLogin();
				break;
			case "accueil":
				echoAccueil();
				break;
			case "licence":
				echoLicence();
				break;
			case "mentions":
				echoMentions();
				break;
			case "panier":
				echoPanier();
				break;
			default:
				echoErreurP();
		}
	}
	else
	{
		if(isset($_REQUEST["essaiLogin"]))
		{
			echoLogin();
		}
		else
		{
			echoAccueil();
		}
	}
	echo '
			<div id="footer">
				<span>© Sylvain Brunerie, Jean-Baptiste Subils</span>
				<a href="licence">Informations de licence</a>
				<a href="mentions">Mentions légales</a>
			</div>			
		</div>

	
   </body>
</html>
';
}

if(isset($_REQUEST["deconnecter"]))
{
	deconnecter();
}
elseif(isset($_REQUEST["essaiLogin"]))
{
	essaiConnexion();
}

echoAll();
close();

?>
