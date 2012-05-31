<?php

function isSelectedOption($val)
{
	if($val == "Ar" && !isset($_REQUEST["categorie"])) // Temporaire !
	{
		return ' selected="selected"';
	}
	elseif(isset($_REQUEST["categorie"]) && $_REQUEST["categorie"] == $val)
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
				<form method="REQUEST" action="">
					<input type="hidden" name="p" value="recherche" />
					<label for="q">Votre recherche : </label>
					<input type="text" id="q" name="q" size="25" placeholder="The Beatles, I am the Walrus…" value="'.(isset($_REQUEST["q"])? $_REQUEST["q"] : "").'" />
					<select name="categorie">
						<option value="tous"'.isSelectedOption("tous").'>Tous</option>
						<option value="Ar"'.isSelectedOption("Ar").'>Artistes</option>
						<option value="Al"'.isSelectedOption("Al").'>Albums</option>
						<option value="Ti"'.isSelectedOption("Ti").'>Titres</option>
					</select>
					<input type="submit" value="Rechercher" />
				</form>
			</div>';
	
	if(isset($_REQUEST["q"]) && isset($_REQUEST["categorie"])) // recherche à effectuer
	{
		echo '
				<h2 class="hRecherche">Recherche</h2>';
		switch($_REQUEST["categorie"])
		{
			case "tous": // Temporaire !
			case "Ar":
				$reqRecherche = mysql_query("SELECT * FROM artistes WHERE NomArtiste LIKE '%".$_GET["q"]."%'") or die("Erreur recherche artiste");
				break;
			case "Al":
				$reqRecherche = mysql_query("SELECT * FROM albums WHERE NomAlbum LIKE '%".$_GET["q"]."%'") or die("Erreur recherche album");
				break;
			case "Ti":
				$reqRecherche = mysql_query("SELECT * FROM titres WHERE NomTitre LIKE '%".$_GET["q"]."%'") or die("Erreur recherche titre");
				break;/*
			case "tous":
				$reqRecherche = mysql_query("SELECT * FROM artistes WHERE NomArtiste LIKE '%$_GET["q"]%'") or die("Erreur recherche artiste");
				break;*/
			default:
				echo "Coucou.";
				break;
		}
		
		$nbResultats = mysql_num_rows($reqRecherche);
		$strNbResultats = '';
		switch($nbResultats)
		{
			case 0:
				$strNbResultats = 'Aucun résultat obtenu.';
				break;
			case 1:
				$strNbResultats = 'Un résultat obtenu.';
				break;
			default:
				$strNbResultats = '' + $nbResultats + ' résultats obtenus.';
		}
		
		echo '
				<p>'.$strNbResultats.'</p>
				<ul>';
		while($ligneRecherche = mysql_fetch_assoc($reqRecherche))
		{
			echo '
					<li><a href="artiste/'.$ligneRecherche["IdArtiste"].'">'.$ligneRecherche["NomArtiste"].'</a></li>';
		}
		
	}
}
