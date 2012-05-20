<?php

function echoArtiste()
{
	echo '
			<div id="contenu" class="cArtiste">';
			
	if(isset($_GET["idArtiste"]) and is_numeric($_GET["idArtiste"]) and $_GET["idArtiste"] > 0)
	{
		// Affichage des informations d’un artiste
		$nomArtiste = "Artiste bidon";
	
		echo '
				<h2 id="nomArtiste">Artiste : '.$nomArtiste.'</h2>
				<p>Désolé, pas plus d’informations pour l’instant.</p>
			</div>';
	}
	else
	{
		// Affichage de la liste de tous les artistes
		
		$reqArtistes = mysql_query("SELECT * FROM artistesTest") or die ("Erreur requête tous artistes");
		$nbArtistes = mysql_num_rows($reqArtistes);
		echo '
				<h2>Liste de tous les artistes enregistrés</h2>
				<p>Il y en a déjà '.$nbArtistes.'&nbsp;:</p>
				<ul>';
		while ($ligneArtiste = mysql_fetch_assoc($reqArtistes))
		{
			echo '
					<li>
						<a href="?p=artiste&amp;idArtiste='.$ligneArtiste["IdArtiste"].'">
							'.$ligneArtiste["NomArtiste"].' <span class="pseudoListe">('.$ligneArtiste["PseudoArtiste"].')</span>
						</a>
					</li>';
		}
		echo '
				</ul>
			</div>';
				
	}
}
?>
