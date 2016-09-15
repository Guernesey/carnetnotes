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
	  <title>Administration</title>
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



	1. Nom de l'établissement<br>
	<?php ecrire_var("10_nomecole","École Saint Jean Eudes") ?>


<!-- 2. PÉRIODE -->
	2. PÉRIODE <br>
	Choisissez la période :
		<form name="periode" method="post" action="92_admin_periode.php">
			<select NAME="periode">
				<?php
					$req=sql_perso("SELECT * FROM Periodes");
					
					/* On affiche ces entrées*/
					while($data = mysql_fetch_assoc($req))
						{
							print '<option value='.$data['Finperiode'].'>'.$data['Finperiode'];
						}
	
					mysql_close();  // on ferme la connexion
				?>
			</select>
		<Input type="submit" value="Valider">
		
<!-- 2. MATIERES -->		
		<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:3em ; margin-left:5em"
	value="9. Administration" 
	onclick="self.location.href='94_admin_matiere.php'" 
	>

</body></html>
