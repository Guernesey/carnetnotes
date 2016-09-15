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
	  <title>Liste des matières</title>
	  <!-- Fichier : SortieCarnet1.php -->
</head><html><body>

<?php include('fonctions/fonctions.php');
	$ecole = lire_var("10_nomecole");
	?>

<font size="5" color="&0000FF"><center>
	<?php echo "$ecole"; ?>
	</center></font>
<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:3em"
	value="> ACCUEIL <" 
	onclick="self.location.href='index.php'" 
	>
	<br>
<?php 
$matiere=$_POST[matiere];
$matiereaff=$_POST[matiereaff];
$classe=$_POST[classe];
$tri=$_POST[tri];


	echo $matiere;
if(!empty($matiere)){
	$serveur = "localhost";
	$user = "saintjeaneudes";
	$password = "8w7Cc8wF";
	$db = "saintjeaneudes";
	$sql = "INSERT INTO Matieres (Matiere1, MatiereAff, Classe, Tri)
			VALUE ('$matiere','$matiereaff','$classe', '$tri')";
	$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
	mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
	$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));

	}

?>

		<form name="Matiere" method="post" action="94_admin_matiere.php">
			<Input type="text" value="" name="matiere">
			<Input type="text" value="" name="matiereaff">
			<Input type="text" value="" name="classe">
			<Input type="text" value="" name="tri">
			<Input type="submit" value="Valider" name="coefficient">

</body></html>
