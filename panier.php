<?php

function echoPanier()
{
	echo '
			<div id="contenu" class="cPanier">';
	
	if(isset($_SESSION["utilisateurNom"]))
	{
		$user = $_SESSION["utilisateurId"];
		$prix = 0;
		
		if(isset($_REQUEST["vider"]))
		{
			$reqViderPanier = mysql_query("DELETE FROM panier WHERE IdUtilisateur=".$user) or die ("Erreur vidage panier");
		}
		
		if(isset($_REQUEST["supprimePanier"])) // on supprime des éléments du panier
		{
			// var_dump($_REQUEST);
			$reqTitresPanier = mysql_query("SELECT * FROM panier WHERE IdUtilisateur = ".$user) or die ("Erreur nom titres panier");
			while($ligneTitre = mysql_fetch_assoc($reqTitresPanier))
			{
				if(isset($_REQUEST["c".$ligneTitre["IdTitre"]]))
				{
					$reqSupprimePanier = mysql_query("DELETE FROM panier WHERE IdTitre = ".$ligneTitre["IdTitre"]." AND IdUtilisateur = ".$user."") or die ("Erreur ajout titre au panier");
				}
			}
		}
				
		$idTitres  = mysql_query("SELECT * FROM titres,panier 
					WHERE panier.IdUtilisateur =".$user."
					AND titres.IdTitre = panier.IdTitre") 
					or die ("Erreur récupération des titres"); 
		
		$albums = mysql_query("SELECT * FROM albums") or die ( "Erreur requete album");

		
		if (mysql_num_rows($idTitres) == 0)
		{
			echo ' 
				<p>Votre panier est vide.</p>';
		}
		else
		{
			while ($ligneAlbum = mysql_fetch_assoc($albums))
			{

				$p = 0;
				$cpt = 0;
				$titresAlbums = mysql_query("SELECT * FROM titresalbums 
											WHERE IdAlbum=".$ligneAlbum["IdAlbum"]) 
								or die ( "Erreur requete album");
				
				while ($ligneTitreAlbum = mysql_fetch_assoc($titresAlbums))
				{
					while ($ligneTitre = mysql_fetch_assoc($idTitres))
					{
						if ($ligneTitre["IdTitre"] == $ligneTitreAlbum["IdTitre"])
						{
							$p += $ligneTitre["Prix"];
							$cpt++;
						}
					}
				}
				if (mysql_num_rows($titresAlbums) == $cpt)
				{
					echo ' T as une reduc !!!!!!!!!!!';
					$prix -= $p*0.1;
				}
				mysql_data_seek($idTitres,0);
			}
			echo '
				<p> Voici les chansons dans votre panier : <p>
				<form method="POST">
					<table>
						<thead>
						<tr>
							<th>Titre</th>
							<!--<th>Artiste</th>-->
							<th>Prix</th>
						</tr>
						</thead>
						<tbody>';
			mysql_data_seek($idTitres,0);
			while  ($ligneTitre = mysql_fetch_assoc($idTitres))
			{
				$prix = $prix + $ligneTitre["Prix"]; // !!!!!!!!!!!!!!!!!! à remplacer par le prix du titre
				echo'
						<tr>
							<td><i>'.$ligneTitre["NomTitre"].'</i></td>
							<!--<td></td>-->
							<td>'.$ligneTitre["Prix"].' €</td>
							<td><input type="checkbox" class="checkTitre" name="c'.$ligneTitre["IdTitre"].'" /></td>
						</tr>';
			
			}
			echo '
					</tbody>
					</table>
					<p class="cocher">
						<a href="javascript:toutCocherDecocher();" rel="cocher" id="bCocher">Tout cocher / Tout décocher</a> 
					</p>
					<input type="submit" value="Supprimer la sélection du panier" name="supprimePanier" id="supprimePanier" />
					<p> Montant total à payer : '.$prix.' € </p>
					<input type="submit" name="vider" value="Vider le panier" />
				</form>';
		}
		
	}
	else
	{
		echo '
				<h2> Il faut être connecté pour avoir un panier </h2>';
	}
	echo '
			</div>';
}

function calculPrix()
{

}
?>
