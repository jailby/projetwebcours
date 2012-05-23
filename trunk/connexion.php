<?php

function connexion()
{
	global $c;	
	
	// Sur mon ordi j’ai configuré MySQL comme ça :
	//     login : root
	//     password : root
	//     base de données : glin607
	// Faudra donc que tu fasses pareil (ou du moins qu’on utilise les mêmes identifiants sur nos deux ordis).
	
	//echo "<pre>"; var_dump($_SERVER); echo "</pre>";
	
	if($_SERVER["HTTP_HOST"] == "localhost")
	{
		if(strpos($_SERVER["SERVER_SOFTWARE"], "CentOS") !== false) 
		// on est à la fac, serveur SQL « Venus »
		{
			$utilisateurDB = "sbrunerie";
		
			$c = mysql_connect("venus", $utilisateurDB, $utilisateurDB) or die("Erreur connect : ".mysql_error());
			mysql_select_db("$utilisateurDB",$c) or die ("Erreur select_db : ".mysql_error());
		}
		elseif(strpos($_SERVER["SERVER_SOFTWARE"], "Unix") !== false) // on est en local sous Unix (Sylvain)
		{
			$utilisateurDB = "root";
		
			$c = mysql_connect("localhost", $utilisateurDB, '') or die("Erreur connect : ".mysql_error());
			mysql_select_db("glin607",$c) or die ("Erreur select_db : ".mysql_error());
			
			$racine = 'http://localhost/~sbrunerie/ArchiWeb/projetwebcours/';
		}
		else // on est en local sous Windows (JB)
		{
			$utilisateurDB = "root";
		
			$c = mysql_connect("localhost", $utilisateurDB, "") or die("Erreur connect : ".mysql_error());
			mysql_select_db("glin607",$c) or die ("Erreur select_db : ".mysql_error());
		
			$racine = 'http://localhost/projetwebcours/';
		}
		
	}	
	elseif($_SERVER["HTTP_HOST"] == "innsbay.toile-libre.org")
	{
		$c = mysql_connect("sql.toile-libre.org", "innsbay_projweb", "GLIN607") or die("Erreur connect : ".mysql_error());
		mysql_select_db("innsbay_projweb",$c) or die ("Erreur select_db : ".mysql_error());

		$racine = 'http://innsbay.toile-libre.org/projetwebcours/';
	}
	else
	{
		echo "<p>Erreur : sur quel serveur est-on ?</p>";
	}
	
	mysql_set_charset("utf8", $c) or die ("Erreur set_charset utf8 : ".mysql_error());
}

function close()
{
	global $c;
	mysql_close($c);
	//echo mysql_errno();
}

?>
