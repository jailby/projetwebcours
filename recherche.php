<?php

function isSelectedOption($val)
{
	if(isset($_REQUEST["categorie"]) && $_REQUEST["categorie"] == $val)
	{
		return ' selected="selected"';
	}
	else
	{
		return '';
	}
}

function echoRecherche()
{
	echo '
			<div id="contenu" class="cRecherche">
				<h2 class="hRecherche">Recherche</h2>
				<form method="REQUEST" action="">
					<input type="hidden" name="p" value="recherche" />
					<label for="q">Votre recherche : </label>
					<input type="text" id="q" name="q" size="25" placeholder="The Beatles, I am the Walrus…" value="'.(isset($_REQUEST["q"])? $_REQUEST["q"] : "").'" />
					<select name="categorie">
						<option value="tout"'.isSelectedOption("tout").'>Tout</option>
						<option value="Ar"'.isSelectedOption("Ar").'>Artistes</option>
						<option value="Al"'.isSelectedOption("Al").'>Albums</option>
						<option value="Ti"'.isSelectedOption("Ti").'>Titres</option>
					</select>
					<input type="submit" value="Rechercher" />
				</form>';
	
	if(isset($_REQUEST["q"]) && isset($_REQUEST["categorie"])) // recherche à effectuer
	{
		echo '
				<div class="divResultatsRecherche">';
		switch($_REQUEST["categorie"])
		{
			case "Ar": // Artiste
				rechercheArtiste();
			break;
			
			case "Al": // Album
				rechercheAlbum();
			break;
				
			case "Ti": // Titre
				rechercheTitre();
			break;
			
			case "tout": // Tout
				rechercheArtiste();
				rechercheAlbum();
				rechercheTitre();
			break;
			
			default:
				// echo "<p>Coucou ?</p>";
			break;
		}
		
		echo '
				</div>';
	}
	echo '
			</div>';
}

function strNbResultats($reqRecherche)
{
	$nbResultats = mysql_num_rows($reqRecherche);
	$strNbResultats = '';
	switch($nbResultats)
	{
		case 0:
			$strNbResultats = 'aucun résultat obtenu.';
			break;
		case 1:
			$strNbResultats = '1 résultat obtenu.';
			break;
		default:
			$strNbResultats = $nbResultats . ' résultats obtenus.';
			break;
	}
	return $strNbResultats;
}

function rechercheArtiste()
{
	$reqRecherche = mysql_query("SELECT * FROM artistes WHERE NomArtiste LIKE '%".$_GET["q"]."%'")
		or die("Erreur recherche artiste");
	echo '
				<p class="pSoustitreRecherche">
					<span class="soustitreRecherche">Recherche d’artistes :</span> '.strNbResultats($reqRecherche).'
				</p>
				<ul class="resultatsRecherche">';
	while($ligneRecherche = mysql_fetch_assoc($reqRecherche))
	{
		echo '
					<li><a href="artiste/'.$ligneRecherche["IdArtiste"].'">'.$ligneRecherche["NomArtiste"].'</a></li>';
	}	
	echo '
				</ul>';	
}

function rechercheAlbum()
{
	$reqRecherche = mysql_query("SELECT * FROM albums WHERE NomAlbum LIKE '%".$_GET["q"]."%'")
		or die("Erreur recherche album");
	echo '
				<p class="pSoustitreRecherche">
					<span class="soustitreRecherche">Recherche d’albums :</span> '.strNbResultats($reqRecherche).'
				</p>
				<ul class="resultatsRecherche">';
	while($ligneRecherche = mysql_fetch_assoc($reqRecherche))
	{
		echo '
					<li><a href="album/'.$ligneRecherche["IdAlbum"].'">'.$ligneRecherche["NomAlbum"].'</a></li>';
	}
	echo '
				</ul>';
}

function rechercheTitre()
{
	$reqRecherche = mysql_query("SELECT * FROM titres WHERE NomTitre LIKE '%".$_GET["q"]."%'")
		or die("Erreur recherche titre");
	echo '
				<p class="pSoustitreRecherche">
					<span class="soustitreRecherche">Recherche de titres :</span> '.strNbResultats($reqRecherche).'
				</p>
				<ul class="resultatsRecherche">';
	while($ligneRecherche = mysql_fetch_assoc($reqRecherche))
	{
		echo '
					<li><a href="titre/'.$ligneRecherche["IdTitre"].'">'.$ligneRecherche["NomTitre"].'</a></li>';
	}
	echo '
				</ul>';
}
