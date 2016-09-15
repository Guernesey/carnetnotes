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
  	<!-- Fichier : Saisie_notes.php -->
</head><html>

	<?php include('fonctions/fonctions.php');
		$ecole = lire_var("10_nomecole");
		?>
	<script src="javascript.js" type="text/javascript" language = "Javascript"></script>

<body>
	<!-- Titre -->
<font size="5" color="&0000FF"><center>
	<?php echo "$ecole"; ?>
	</center></font>
	<!-- Bouton accueil -->
<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:0em"
	value="> ACCUEIL <" 
	onclick="self.location.href='index.php'" 
	>
	<br>
	<!-- Bouton annuler -->
<input type="button" name="lien1" class="style1" style="margin-top:0em ; margin-bottom:3em"
	value="> Annuler <" 
	onclick="self.location.href='11_entree_notes1.php'" 
	>
	<br>
	

<?php
	$message = $_SESSION[message];
	setlocale(LC_TIME, 'fra_fra');
	$date = strftime('%A %d %B %Y');
	$periode = lire_var("periode");
	$classe = $_SESSION[classe];
	$matiere = $_SESSION[matiere];
	$type = $_SESSION[type];
	$nbeleves = $_SESSION[nbeleves];
?>

	

<?php
	$serveur = psql_serveur();
	$user = psql_user();
	$password = psql_password();
	$db = psql_db();



/*--------------
 Création d'enregistrements vides dans la table Notes avec les élèves de la classe voulue */
$sql = "SELECT * FROM Classes WHERE Classe='$classe'";
		$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
		mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion);
		$req=mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());

/*---------------
 On crée les enregistrements s'ils n'existent pas encore */
$sqlh = "SELECT * FROM Notes WHERE Notes.Classe = '$classe' AND Notes.Matiere = '$matiere' AND Notes.Type = '$type' AND Notes.Periode = '$periode'";
	$reqh=mysql_query($sqlh) or die('Erreur SQL !'.$sqlh.'<br>'.mysql_error());
	$nbeleves = mysql_num_rows($reqh);
if($nbeleves < 1)
		{	while($data = mysql_fetch_assoc($req))
					{	$IndEleve = $data['Indexs'];
					$sqli = "INSERT INTO Notes (IndEleve, Classe, Matiere, Type, Periode) 
							VALUES ('$IndEleve', '$classe', '$matiere', '$type', '$periode')";
					$reqi=mysql_query($sqli) or die('Erreur SQL !'.$sqli.'<br>'.mysql_error());
					}
		}

/*----------------
 Liste des élèves */
$sql = "SELECT * FROM Classes
	INNER JOIN Notes ON Notes.IndEleve=Classes.Indexs
	WHERE Notes.Classe = '$classe' AND Notes.Matiere = '$matiere' AND Notes.Type = '$type' AND Notes.Periode = '$periode'
	ORDER BY Classes.Nom, Classes.Prenom";
		$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
		mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
		mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion);
		$req=mysql_query($sql) or die('Erreur SQL !'.$sql.'<br>'.mysql_error());
$nbeleves = mysql_num_rows($req);					
//echo "<br>Nombre d'élèves : $nbeleves<br><br>";

?>



<!--===================
		Début du formulaire  -->
	
<form name="carnetnotes" method="post" action="14_saisie_notes2.php">
	
<!-- -----------------
		Affichage de classe, matière et type concernés -->
<center><b><?php echo "$classe : $matiere - $type "; ?></b></center> <br>

<?php
	$i = 1;
	$prenom = array();
	$nom = array();
	$indexs = array();
	$note_prec = array();
	$t_note = array(1,2,3);
?>

<!-- -----------------
		Tableau du formulaire -->
<div style="min-height: 100%">
<center>
	<table width="400" border="1" cellpadding=2 >
		<tr><td width="120">Prénom</td><td width="120">Nom</td><td>Note</td></tr>
		<tr>
			<?php 
				$i = 1;
			while($data = mysql_fetch_assoc($req))
				{
					$prenom[$i] = $data['Prenom'];
					$nom[$i]  = $data['Nom'];
					$indexs[$i] = $data['Indexs'];
					$note = "note".$i;
					$note_prec[$i] = $data['Note'];
					?> 
						<td><?php;echo utf8_encode($prenom[$i]);?></td><td><?php;echo utf8_encode($nom[$i]);?></td><!--<td><?php;echo $indexs[$i];?></td>-->
						<td><input type='text' name="<?php echo $note; ?>" value="<?php echo $note_prec[$i]; ?>"></td></tr>
					<?php
					$i += 1;
				}
			
			//echo "<font color='&FF0000'>$message<br></font>";
			mysql_close();  // on ferme la connexion
			?>
	</table>
<br>

<Input type= "submit" value="Valider" class="style1"></form>
</center>
</div><br>

<div style="text-align:right ; margin-top:3em">
	<p>
	Entrez les notes sous la forme 2.5/a/abs/10/5.5<br>
	«Valider» écrase les valeurs précédentes.</p></div>
</body></html>
