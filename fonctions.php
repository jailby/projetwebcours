<?php

function echoErreurP()
{
	if(isset($_GET["p"]))
	{
		echo '
			<div id="contenu" class="cErreurP">
				<p>Désolé, le paramètre «&nbsp;'.$_GET["p"].'&nbsp;» n’a pas été reconnu.</p>
			</div>';
	}
	else
	{
		echoAccueil();
	}
}

function echoLicence()
{
	echo '
			<div id="contenu" class="licence">
				<p>Tout le contenu de ce site est mis à disposition sous la licence Creative Commons <a href="http://creativecommons.org/licenses/by-sa/2.0/fr/">CC-BY-SA</a> (créditer Sylvain Brunerie et Jean-Baptiste Subils).</p>
			</div>';
}

function echoMentions()
{
	echo '
			<div id="contenu" class="mentions">
				<p>(Il faut mettre quoi dans les mentions légales ?)</p>
			</div>';
}

?>
