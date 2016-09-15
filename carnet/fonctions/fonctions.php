<?php
session_start();
ini_set ('session.bug_compat_42', 0);
ini_set ('session.bug_compat_warn', 0); 

function aff_tab($array,$nom){
	echo "Affichage(".$nom."):<br><pre>";
	print_r($array);
	echo "</pre>";
	}

function ecrire_var($fichierecrire,$varecrire){
	$fp = fopen("variables/".$fichierecrire,"w"); 
	fputs($fp,$varecrire); 
	fclose($fp);
}

function lire_var($fichierlire){
	$fp = fopen("variables/".$fichierlire,"r"); 
	$varlire = fgets($fp,255); 
	fclose($fp);
	return $varlire;
}

function psql_serveur(){
	return "localhost";}
function psql_user(){
	return "saintjeaneudes";}
function psql_password(){
	return "8w7Cc8wF";}
function psql_db(){
	return "saintjeaneudes";}

	

function sql_perso($mysqlperso){
$serveur = "localhost";
$user = "saintjeaneudes";
$password = "8w7Cc8wF";
$db = "saintjeaneudes";
$sql = $mysqlperso;
$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
/* mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion); */
$reqperso = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion)) ;
return $reqperso ;
}



function calcul($eleve)
{
/* =================== */
$classe = $_POST[classe];
$periode = lire_var("periode");
$indPer = substr($periode, -1);
$moyennes = array(); /* Cette matrice à 3 colonnes contiendra les notes, index et places des élèves */ 

$serveur = "localhost";
$user = "saintjeaneudes";
$password = "8w7Cc8wF";
$db = "saintjeaneudes";
$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());

/*======================================
Calcul des moyennes sur la période concernée de chaque élève pour déterminer le classement */

$sql = "SELECT * FROM Periodes WHERE Finperiode = '$periode'";
$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
while($data = mysql_fetch_assoc($req))
	{
		$debut = $data[Debutperiode];
		$fin = $data[Finperiode];
	}
$_SESSION[debut] = $debut;
$_SESSION[fin] = $fin;

/* Liste des index élèves concernés */ 
$sql = "SELECT * FROM Classes WHERE Classe = '$classe'";
$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
$i = 1;
$nbeleves = mysql_num_rows($req);
while($data = mysql_fetch_assoc($req))
	{
		$index[$i] = $data['Indexs'];
		$i += 1;
	}

/* Somme puis moyenne des notes concernées pour chaque élève */
for($i = 1; $i <= $nbeleves; ++$i) 
	{
		$sql = "SELECT SUM(somme) AS som, SUM(nombre) AS nomb FROM Notes WHERE IndEleve = '$index[$i]' AND Periode='$periode'";
		$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
		$somme[$i] = 0;
		$nombre[$i] = 0;
		while($data = mysql_fetch_assoc($req))
			{
			$somme[$i] = $somme[$i] + $data[som];
			$nbnotes[$i] = $nbnotes[$i] + $data[nomb];
			$moyenne[$i] = $somme[$i]/$nbnotes[$i];
			$moyennes[$i][0] = $moyenne[$i];
			$moyennes[$i][1] = $index[$i];
			$moyennes[$i][2] = 8;
			
			/*echo "<br>$i $index[$i] Somme$i : $somme[$i] nombre : $nbnotes[$i] Moyenne : $moyenne[$i]"; */
			}
		
	} 
rsort($moyennes);
/* Introduction des places dans la matrice. 
Puisque les notes et index sont rangés en ordre décroissant de notes, on attribue les places facilement. */
for($i = 0; $i <= $nbeleves - 1; ++$i) 
	{
		$moyennes[$i][2] = $i + 1;
	}

/* Repérer la ligne correspondant à $eleve */

for($i = 0;$i <= $nbeleves - 1; ++$i) 
	{
		if($moyennes[$i][1] == $eleve)
			{
			$truc = $moyennes[$i][2];
			}
	}
/* echo "<br>Elève : $eleve Truc : $truc"; */
return "$truc";
}
?>
