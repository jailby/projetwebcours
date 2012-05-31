<?php
function echoLogin()
{
	echo '
			<div id="contenu" class="cLogin">
				<h2 id="hLogin">Connexion</h2>';
	
	if(!isset($_SESSION["utilisateurNom"])) // on n’est pas connecté
	{
		echo '
					<form method="POST" action="login">
						<fieldset>
							<legend>Connexion</legend>
							<label for="inputUser">Pseudo</label>
							<input type="text" id="inputUser" name="user" />
							<label for="inputMdp">Mot de passe</label>
							<input type="password" id="inputMdp" name="password" />
							<input type="hidden" name="essaiLogin" />
							<input type="submit" value="Se connecter" />
						</fieldset>
					</form>
			</div>';
	}
	else
	{
		echo '
					<p>'.loginStatut().'</p>';
	}
}

function loginStatut()
{
	if(isset($_SESSION["utilisateurNom"]))
	{
		return 'Connecté en tant que <span class="utilisateur">'.$_SESSION["utilisateurNom"].'</span>. <a href="?deconnecter">Se déconnecter</a>';
	}
	else
	{
		return ''; // ou 'Pas connecté.'
	}
}

function essaiConnexion()
{
	if(isset($_REQUEST["password"]))
	{
		$reqLogin = mysql_query("SELECT * FROM utilisateurs WHERE Login='".$_REQUEST["user"]."'
		 AND Password='".sha1($_REQUEST["password"])."'");
		
		if($ligneLogin = mysql_fetch_assoc($reqLogin))
		{
			// echo "Connexion réussie.";
			connecter($ligneLogin);
		}
		else
		{
			// echo "Connexion échouée.";
		}
	}
}

function connecter($ligneLogin)
{
	$_SESSION["utilisateurNom"] = $ligneLogin["Login"];
	$_SESSION["utilisateurId"] = $ligneLogin["IdUtilisateur"];
	header('Location: index.php?bye');
}

function deconnecter()
{
	session_unset();
	header('Location: index.php?bye');
}
