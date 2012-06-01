<?php

function echoPanier()
{
	if(isset($_SESSION["utilisateurNom"]))
	{
		$user = $_SESSION["utilisateurId"];
		$prix = 0;
		
		$idTitres  = mysql_query("SELECT * FROM titres,panier 
					WHERE panier.IdUtilisateur =".$user."
					AND titres.IdTitre = panier.IdTitre") 
					or die ("Erreur récupération des titres"); 
		
		$albums = mysql_query("SELECT * FROM albums") or die ( "Erreur requete album");
		
		if (mysql_num_rows($idTitres) == 0)
		{
			echo ' 
				<p> Votre panier est vide</p>';
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
				while ($ligneTitre = mysql_fetch_assoc($idTitres))
				{
					while ($ligneTitreAlbum = mysql_fetch_assoc($titresAlbums))
					{
						if ($ligneTitre["IdTitre"] == $ligneTitreAlbum["IdTitre"])
						{
							p +=
						}
					}
				}
				mysql_data_seek($idTitres,0);
			}
			echo '
				<p> Voici les Chanson dans votre panier :<p>
				<table>';
			mysql_data_seek($idTitres,0);
			while  ($ligneTitre = mysql_fetch_assoc($idTitres))
			{
				$prix = $prix + 1; // !!!!!!!!!!!!!!!!!! à remplacer par le prix du titre
				echo'
					<tr><td>'.$ligneTitre["NomTitre"].'</td><td>'.$ligneTitre["Prix"].'</td></tr>';
			
			}
			echo '
				</table>
				<p> Voici le montant que vous avez à payer : '.$prix.'<br\>';
		}
		
	}
	else
	{
		echo '<h2> Il faut être connecté pour avoir un panier </h2>';
	}
}

function calculPrix()
{

}
?>