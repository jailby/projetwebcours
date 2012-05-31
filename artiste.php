<?php

function spanPseudoArtiste($pseudoArtiste, $classe)
{
	if(!isset($classe))
	{
		$classe = "pseudo";
	}
	if($pseudoArtiste)
	{
		return ' <span class="pseudoTitre">('.$pseudoArtiste.')</span>';
	}
	else
	{
		return '';
	}
}

function echoArtiste()
{
	echo '
			<div id="contenu" class="cArtiste">';
	
	if(isset($_GET["idArtiste"]) and is_numeric($_GET["idArtiste"]) and $_GET["idArtiste"] > 0)
	{
		// Affichage des informations d’un artiste
		
		$idArtiste = $_GET["idArtiste"];
		
		$reqArtiste = mysql_query("SELECT * FROM artistes WHERE IdArtiste=".$idArtiste) or die ("Erreur requête artiste");
		$artisteSelect = mysql_fetch_assoc($reqArtiste);
		$nomArtiste = $artisteSelect["NomArtiste"];
		$pseudoArtiste = $artisteSelect["PseudoArtiste"];
		
		echo '
				<h2 id="nomArtiste">[Artiste] '.$nomArtiste.spanPseudoArtiste($pseudoArtiste, "pseudoTitre").'</h2>
				<a class="lienTous" href="artiste">« Tous les artistes</a>';
		
		// Liste des albums :
		
		$reqAlbumsArtiste = mysql_query("SELECT albums.IdAlbum, albums.NomAlbum FROM albums JOIN artistesalbums ON albums.IdAlbum = artistesalbums.IdAlbum WHERE IdArtiste = ".$artisteSelect["IdArtiste"]) or die ("Erreur requête albums artiste");
		echo '
				<p>Liste des albums de cet artiste :</p>
					<ul class="listeAlbumsArtiste">';
		while ($ligneAlbum = mysql_fetch_assoc($reqAlbumsArtiste))
		{
			echo '
						<li><a href="album/'.$ligneAlbum["IdAlbum"].'">'.$ligneAlbum["NomAlbum"].'</a></li>';
		}
		
		echo '
			</div>';
	}
	else
	{
		// Affichage de la liste de tous les artistes
		
		$reqArtistes = mysql_query("SELECT * FROM artistes") or die ("Erreur requête tous artistes");
		$nbArtistes = mysql_num_rows($reqArtistes);
		echo '
				<h2>Liste de tous les artistes enregistrés</h2>
				<p>Il y en a déjà '.$nbArtistes.'&nbsp;:</p>
				<ul>';
		while ($ligneArtiste = mysql_fetch_assoc($reqArtistes))
		{
			echo '
					<li>
						<!--<a href="?p=artiste&amp;idArtiste='.$ligneArtiste["IdArtiste"].'">-->
						<a href="artiste/'.$ligneArtiste["IdArtiste"].'">
							'.$ligneArtiste["NomArtiste"].spanPseudoArtiste($ligneArtiste["PseudoArtiste"], "pseudoListe").'
						</a>
					</li>';
		}
		echo '
				</ul>
			</div>';
				
	}
}
?>
