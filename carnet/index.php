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
  	<title>Carnet de notes</title>
  	<!-- Fichier : index.html -->
</head><html><body>

<?php 
	include ('fonctions/fonctions.php');
	$sql=psql_serveur();
	$texte = lire_var("periode");
	$ecole = lire_var("10_nomecole"); ?>
	
<!-- Titre -->
<font size="5" color="&0000FF"><center>
	<?php echo "$ecole et $sql"; ?>
	</center></font>

<p style="color:red ; text-align:right ; margin-right:5em">
Période actuelle : <?php echo $texte ?><br style="margin-bottom:3em">
</p>

<!-- 1. Entrer les notes -->
<font size="3" color="&0000FF">
<p  style="margin-bottom:0em ; margin-left:4.5em">
	 1. Entrer les notes <p>
		<form name="classe" method="post" action="11_entree_notes1.php">
			<select name="classe" style="margin-bottom:1.5em ; margin-left:5em">
				<option value="CP">CP</option>
			   	<option value="CE1">CE1</option>
			   	<option value="CE2">CE2</option>
			   	<option value="CM1">CM1</option>
			   	<option value="CM2">CM2</option>
			</select>
			<input type="submit" value="Éditer">
		</form>
		
<!-- 8. Afficher les carnets de notes de la classe de : -->
<p  style="margin-bottom:0em ; margin-left:4.5em">
	 8. Afficher les carnets de notes de la classe de :<p>
	 	<form name="classe" method="post" action="80_sortie_notes.php">
			<select name="classe" style="margin-bottom:1.5em ; margin-left:5em">
				<option value="CP">CP</option>
			   	<option value="CE1">CE1</option>
			   	<option value="CE2">CE2</option>
			   	<option value="CM1">CM1</option>
			   	<option value="CM2">CM2</option>
			</select>
			<input type="submit" value="Afficher">
		</form>
<br>

<!-- 9. Administration -->
<p  style="margin-bottom:0em ; margin-left:4.5em">
	 9. Administration<p>
<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:3em ; margin-left:5em"
	value="9. Administration" 
	onclick="self.location.href='90_administration.php'" 
	>
<br>

<!-- Commentaires sur l'état du logiciel -->
<p style="color:red">
L'abbé d'Abbadie vous demande de rentrer les retards… à la main le jour du carnet.<br>
Car un retard ou un mauvais comportement peut survenir le jeudi…<br>
====>> 14 sept 14:00, normalement tout est en ordre. Continuez de vérifiez, s'il-vous-plaît.<br>
J'offre une bière à celle qui trouve un bug! (Je ne m'engage pas à grand-chose.)<br>
Vérifiez s'il-vous-plaît que les notes de chacun arrive bien dans le bon carnet, dans la bonne matière.<br><br>
Et une bière pour Mme de Corson ! Merci d'avoir trouvé ce beau bug qui m'a pris 1h30 et 30min à mon père… :<br>
Les notes du premier étaient enregistrées chez le second et ainsi de suite… Bug résolu.</p>
</font></body></html>
