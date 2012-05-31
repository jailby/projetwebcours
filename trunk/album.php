<?php

function echoAlbum()
{
	echo '
			<div id="contenu" class="cAlbum">';
	
	if(isset($_REQUEST["idAlbum"]) and is_numeric($_REQUEST["idAlbum"]) and $_REQUEST["idAlbum"] > 0)
	{
		$nomAlbum = "Album bidon"; // récupérer nom de l’album dans la base de données à partir de idAlbum
	
		echo '
				<h2 id="nomAlbum">Album : '.$nomAlbum.'</h2>
				<p>Désolé, pas plus d’informations pour l’instant.</p>';
	}
	else
	{
		// Liste de tous les albums
		echo '
				<h2 id="nomAlbum">Liste de tous les albums enregistrés</h2>
				<p>(Bientôt)</p>';
	}
	echo '
			</div>
			';
}
?>
