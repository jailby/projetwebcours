<?php

function echoAlbum()
{
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
		
		echo '
				<h2 id="nomAlbum">Album : '.$nomAlbum.'</h2>
				<a class="lienTous" href="album">Tous les albums</a>
				<ol>';
		while ($ligneTitre = mysql_fetch_assoc($reqNomTitres))
		{
			echo '
					<li><a href="titre/'.$ligneTitre["IdTitre"].'">'.$ligneTitre["NomTitre"].'</a></li>';
		}
		echo '	</ol>';
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
