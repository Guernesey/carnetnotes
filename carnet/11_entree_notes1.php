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
  	<title>Entrée des notes</title>
  <!-- Fichier : entrenotes.php -->
</head><html><body>

<?php include('fonctions/fonctions.php');
	$ecole = lire_var("10_nomecole");
	?>



	<!-- Titre -->
<font size="5" color="&0000FF"><center>
	<?php echo "$ecole"; ?>
	</center></font>
	<!-- Bouton Acceuil -->
<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:3em"
	value="> ACCUEIL <" 
	onclick="self.location.href='index.php'" 
	>
	<br>
<!--===================-->

<?php
// Récupération de la variable classe: deux cas
		// Premier cas, on arrive depuis l'index, $_POST est renseigné et on l'enregistre dans $classe
		// Deuxième cas, on arrive depuis le 14…php, et $_POST n'est pas renseigné mais on peut
		//		récupérer $_SESSION.
$classe=null;
if(empty($_POST[classe])){
		$classe=$_SESSION[classe];
		}
	else{
		$classe=$_POST[classe];
		$_SESSION[classe]=$classe;
		}


//if(empty($_SESSION[classe])){$_SESSION[classe]="Choisissez :";}
//echo "$Date<br>";
?>
<font size="4">
<table style="border:none ; margin-left:10em">
<form name="notes" method="post" action="12_entree_notes2.php">
		<!-- On va demander de quelle classe il s'agit 
		<font size="4">
		<table style="border:none ; margin-left:10em">
		<tr><td>
				Classe :
			</td><td>
				<select name="classe" style="width:150px" action="12_entree_notes2.php">
					<option value="<?php echo $_SESSION[classe]; ?>"><?php echo $_SESSION[classe]; ?></option>
						<option value="CP">CP</option>
						<option value="CE1">CE1</option>
						<option value="CE2">CE2</option>
						<option value="CM1">CM1</option>
						<option value="CM2">CM2</option>
				</select>
		</tr><tr><td>-->

	<!-- On affiche la classe -->

		
		<tr><td>Classe :</td><td><?php echo $classe; ?></td>

	<!-- On va maintenant demander la matière et le type que l'on va rechercher dans la base-->

		<tr><td>
				Matière :
			</td><td>
				<select NAME="matiere" style="width:150px">	
					<?php
					$serveur = psql_serveur();
					$user = psql_user();
					$password = psql_password();
					$db = psql_db();
						$sql = "SELECT * FROM Matieres WHERE Classe = '$classe' ORDER BY Tri";
					$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
					mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
					/* mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion); */
					$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));

					
					/* On affiche ces entrées*/
					while($data = mysql_fetch_assoc($req))
						{
							print '<option value='.$data['Matiere1'].'>'.$data['Matiere1'];
						}
					mysql_close();  // on ferme la connexion
					?>
				</select>
		</td></tr><tr><td>

	<!-- On va maintenant demander le type -->

				Type :
			</td><td>
				<select style="width:150px" name="type">
						<option value="Controle">Controle</option>
						<option value="Ecrit">Ecrit</option>
						<option value="Oral">Oral</option>
				</select>
			</td>
		</td></tr>
		<tr><td></td> <td style="text-align: right">
	<Input type="submit" value="Valider">
</td></tr>
</table>
</font>



</body>
</html>

