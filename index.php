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

connexion();

function getSelectedP($param)
{
	if(isset($_GET["p"]) && $_GET["p"] == $param)
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
		<script type="text/javascript" src="script.js"></script>
		<title>Titre !</title>
	</head>
	<body>
		<div id="main">
			<div id="entete">
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
						<li><a href="recherche"'.getSelectedP("recherche").'>Recherche</a></li>
					</ul>
				</div>
			</div>
';
	if(isset($_GET["p"]))
	{
		switch($_GET["p"])
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
			default:
				echoErreurP();
		}
	}
	else
	{
		echoAccueil();
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

echoAll();
close();

?>
