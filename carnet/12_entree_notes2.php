<?php
session_start();
ini_set ('session.bug_compat_42', 0);
ini_set ('session.bug_compat_warn', 0); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<meta charset="UTF-8">

<head>
 	<link rel="stylesheet" type="text/css" href="style/style_affichage.css"/>
  	<title>Saisie des notes</title>
  <!-- Fichier : 12_entree_notes2.php -->
  
  <?php include('fonctions/fonctions.php');
		$ecole = lire_var("10_nomecole");
		?>

</head><html>
<body>
<font size="5" color="&0000FF"><center>Ecole Saint Jean Eudes</center></font><br><br>

<?php
	setlocale(LC_TIME, 'fra_fra');
	$date = strftime('%A %d %B %Y');
	echo "Date : $date<br>";
	$classe = $_SESSION[classe];
	$Matiere = $_POST[matiere];
	$Type = $_POST[type];
	echo "la classe est : $classe ";
	echo "et la matière : $Matiere $Type<br>";

/* On va chercher la liste des élèves de cette classe */
	$serveur = psql_serveur();
	$user = psql_user();
	$password = psql_password();
	$db = psql_db();
		$sql = "SELECT * FROM Classes WHERE Classe = '$classe' ORDER BY Nom";
	$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
	mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
	/* mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion); */
		$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
		$nbeleves = mysql_num_rows($req);					

/* On affiche ces entrées */
echo "<br>Nombre d'élèves : $nbeleves<br><br>";
	$i = 1;
	$prenom = array();
	$nom = array();
	$indexs = array();
while($data = mysql_fetch_assoc($req))
	{
		$prenom[$i] = $data['Prenom'];
		$nom[$i]  = $data['Nom'];
		$indexs[$i] = $data['Indexs'];
		echo "$prenom[$i] $nom[$i] $indexs[$i]<br>";
		$i += 1;
	}
mysql_close();  // on ferme la connexion

/* On passe toutes les variables en session */
$_SESSION[$IndEleve]=$indexs;
aff_tab($_SESSION[$IndEleve],"IndEleve");
$_SESSION[classe] = $classe;
$_SESSION[matiere] = $Matiere;
$_SESSION[type] = $Type;
$_SESSION[nbeleves] = $nbeleves;

header('Location: 13_saisie_notes1.php');
?>
<a href="13_saisie_notes1.php">Cliquer ici pour entrer les notes</a>


</body></html>
