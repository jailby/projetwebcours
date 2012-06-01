<?php

function echoAlbum()
{
	if(isset($_SESSION["utilisateurNom"]))
	{
		$connected = true;
	}
	else
	{
		$connected = false;
	}
	// TODO: Afficher cases à cocher et tout seulement si connecté
	
	echo '
			<div id="contenu" class="cAlbum">';
	
	if(isset($_REQUEST["idAlbum"]) and is_numeric($_REQUEST["idAlbum"]) and $_REQUEST["idAlbum"] > 0)
	{
		
		$idAlbum = $_REQUEST["idAlbum"];
		
		
		$reqAlbum = mysql_query("SELECT * FROM albums WHERE IdAlbum=".$idAlbum) or die ("Erreur requête album");
		
		$albumSelect = mysql_fetch_assoc($reqAlbum);
		$nomAlbum = $albumSelect["NomAlbum"];
		
		//$reqIdTitres = mysql_query("SELECT IdTitre FROM titresalbums WHERE IdAlbum=".$idAlbum) or die ("erreur récuperation des titres");
		//$reqTitres = mysql_query("SELECT * FROM titres WHERE IdTitres=".$reqIdTitres) or die ("");
		
		$reqNomTitres = mysql_query("SELECT * FROM titres,titresalbums
									WHERE titres.IdTitre = titresalbums.IdTitre
									AND titresalbums.IdAlbum =".$idAlbum) 
									or die ("Erreur récupération des noms des titres");
		
		$reqArtisteAlbum = mysql_query("SELECT * FROM artistes JOIN artistesalbums
										ON artistes.IdArtiste = artistesalbums.IdArtiste AND IdAlbum = ".$idAlbum)
										or die ("Erreur récupération nom artiste album");
		
		// Artiste(s) de l’album
		$premierArtiste = mysql_fetch_assoc($reqArtisteAlbum);
		$strArtistes = '<a href="artiste/'.$premierArtiste["IdArtiste"].'">'.$premierArtiste["NomArtiste"].'</a>'; // premier artiste (pas de virgule avant)
		while($ligneArtiste = mysql_fetch_assoc($reqArtisteAlbum))
		{
			$strArtistes .= ', <a href="artiste/'.$ligneArtiste["IdArtiste"].'">'.$ligneArtiste["NomArtiste"].'</a>';
		}
		echo '
				<h2 id="nomAlbum">Album : <i>'.$nomAlbum.'</i></h2>
				<h3 id="nomArtistesAlbum">'.$strArtistes.'</h3>
				<a class="lienTous" href="album">Tous les albums</a>
				<p>Liste des titres de l’album :</p>
				<form id="formTitres" method="POST">
					<ol>';
		while ($ligneTitre = mysql_fetch_assoc($reqNomTitres))
		{
			echo '
						<li>'.($connected? '<input type="checkbox" class="checkTitre" name="c'.$ligneTitre["IdTitre"].'" />':'').'<a href="titre/'.$ligneTitre["IdTitre"].'">'.$ligneTitre["NomTitre"].'</a></li>';
		}
		echo '		</ol>';
		
		if($connected)
		{
			echo '
					<p class="cocher">
						<a href="javascript:toutCocherDecocher();" rel="cocher" id="bCocher">Tout cocher / Tout décocher</a> 
					</p>
					<input type="hidden" name="ajoutePanier" />
					<input type="submit" value="Ajouter la sélection au panier" id="submitPanier" />';
		}
		echo '
				</form>';
		
		if(isset($_REQUEST["ajoutePanier"])) // on ajoute des éléments au panier
		{
			// var_dump($_REQUEST);
			mysql_data_seek($reqNomTitres, 0);
			while($ligneTitre = mysql_fetch_assoc($reqNomTitres))
			{
				if(isset($_REQUEST["c".$ligneTitre["IdTitre"]]))
				{
					// echo "Ajout de titre ".$ligneTitre["IdTitre"]." au panier.";
					$reqAjoutPanier = mysql_query("INSERT INTO panier VALUES(".$ligneTitre["IdTitre"].", ".$_SESSION["utilisateurId"].")") or die ("Erreur ajout titre au panier");
				}
			}
		}
	}
	else
	{
		// Liste de tous les albums
		$reqAlbums = mysql_query("SELECT * FROM albums") or die ("Erreur requête albums");
		
		echo '
				<h2 id="nomAlbum">Liste de tous les albums enregistrés</h2>
				<ul class"listeAlbums" >';
				
		while ($ligneAlbum = mysql_fetch_assoc($reqAlbums))
		{
			echo '
						<li><a href="album/'.$ligneAlbum["IdAlbum"].'">'.$ligneAlbum["NomAlbum"].'</a></li>';
		}
		echo '	</ul>';
	}
	echo '
			</div>';
}
?>
