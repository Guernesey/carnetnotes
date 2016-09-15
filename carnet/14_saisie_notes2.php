<?php
session_start();
ini_set ('session.bug_compat_42', 0);
ini_set ('session.bug_compat_warn', 0); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<!-- <meta charset="UTF-8"> -->
<head>
	<link rel="stylesheet" type="text/css" href="style/style_affichage.css" />
  <title>Saisie des notes</title>
  <!-- Fichier : Saisie_notes1.php -->
  <?php include('fonctions/fonctions.php') ?>
</head><html>

<body>
<font size="5" color="&0000FF"><center>Ecole Saint Jean Eudes</center></font><br><br>

<!-- Boutons de retour -->
	<input type="button" name="lien1" class="style1"
	value="Acceuil" 
	onclick="self.location.href='index.php'" 
	> 
	<input type="button" name="lien1" class="style1"
	value="Entrée des notes" 
	onclick="self.location.href='11_entree_notes1.php'" 
	> 
	<br>
<!-- Capture des notes saisies -->
	
	<?php
	$nbeleves = $_SESSION[nbeleves];
	$matiere = $_SESSION[matiere];
	$type = $_SESSION[type];
	$classe = $_SESSION[classe];
	$date = date("Y-n-d");

	$serveur = psql_serveur();
	$user = psql_user();
	$password = psql_password();
	$db = psql_db();
		$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
	mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());

/* Détermination de IndMat et IndType */
$sql = "SELECT * FROM `Matieres` WHERE Matiere1 = '$matiere'";
$req = mysql_query($sql, $connexion) or die('Erreur SQL ! '.$sql.'<br>'.mysql_error());
	while($data = mysql_fetch_assoc($req))
		{
			$IndMat = $data['IndMat'];
		} 

	switch($type)
		{
		case "Controle":
			$IndType = 1;
			break;
		case "Ecrit":
			$IndType = 2;
			break;	
		case "Oral":
			$IndType = 3;
			break;	
		}
	
/* ENTRÉE des notes dans la table */

$IndEleve=$_SESSION[$IndEleve];
aff_tab($IndEleve,"IndEleve");

for($i = 1; $i <= $nbeleves; ++$i) 
	{										//D'abord on calcule la somme et le nombre de notes.
		$note = "note".$i;
		$t_note[$i] = $_POST[$note];
		echo "i=$i // note=$note // t_note[$i]=$t_note[$i]<br>";
		$periode = lire_var("periode");
		$lesnotes = explode("/", $t_note[$i]);
			$search  = array('abs','a');
			$replace = array('','');
			$note_r=str_replace($search,$replace,$t_note[$i]);
			echo $note_r;
		$nbnotes = str_word_count($note_r, 0, '0123456789.,');
		$sommenotes = array_sum($lesnotes);
		$moyenne = $sommenotes/$nbnotes;
		$Eleve = $_SESSION[$IndEleve][$i];


			//echo "$i ! $t_note[$i] * $nbnotes $moyenne<br>";
			aff_tab($lesnotes);
			echo "<br>nbnotes= $nbnotes";
			echo "Eleve= $Eleve // Notes= $t_note[$i] <br><br> ";
			
											//On efface les notes précédentes
		$sql = "DELETE FROM Notes WHERE IndEleve='$Eleve' AND Matiere='$matiere' AND Type='$type' ";
		$req=mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
											//On entre les nouvelles
		$sql = "INSERT INTO Notes (IndEleve, Classe, Matiere, IndMat2, Type, IndType, Date1, Periode, somme, nombre, Note) 
				VALUES ('$Eleve', '$classe', '$matiere', '$IndMat', '$type', '$IndType', '$date', '$periode', '$sommenotes', '$nbnotes', '$t_note[$i]')";
		$req=mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
	}

		
mysql_close();
header('Location: 11_entree_notes1.php');
?>

</body></html>
