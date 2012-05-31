<?php
function echoAccueil()
{
	echo '
			<div id="contenu" class="cAccueil">
				<p>Page d’accueil.</p>
				<form action="truc.php" method="get">
					<input type="text" name="texte" value="test" />
					<input type="submit" name="OK" />
					<input type="submit" name="s2" value="Submit2" />
				</form>
			</div>';
				
}
?>
