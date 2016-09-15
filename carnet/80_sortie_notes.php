<?php
session_start();
ini_set ('session.bug_compat_42', 0);
ini_set ('session.bug_compat_warn', 0); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<meta charset="UTF-8">
<head>
	<link rel="stylesheet" href="style/style_sortie.css"/>
	  <title>Présentation des notes</title>
	  <!-- Fichier : SortieCarnet1.php -->
</head><html><body>

<?php include('fonctions/fonctions.php');
	$ecole = lire_var("10_nomecole");
	?>
<!--===================-->
	
<?php
/* ===================
Boucle sur les élèves de la CLASSE choisie*/

$classe = $_POST[classe];

//date de fin
$periode = lire_var("periode");
//date de début
	$serveur = psql_serveur();
	$user = psql_user();
	$password = psql_password();
	$db = psql_db();
		$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
		mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
	$sql = "SELECT * FROM Periodes WHERE Finperiode = '$periode'";
		$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
	while($data = mysql_fetch_assoc($req))
			{
				$debut = $data[Debutperiode];
			}
//conversion des dates en format écrit (d comme début, f comme fin, j comme jour, m comme mois)
$dexplode = explode("-",$debut);
$fexplode = explode("-",$periode);
	$jd = $dexplode[2];
	$md = $dexplode[1];
	$jf = $fexplode[2];
	$mf = $fexplode[1];
		$search  = array('01', '02', '03', '04', '05','06','07','08','09');
		$replace = array('1<SUP>er<\SUP>','2','3','4','5','6','7','8','9');
		$jd = str_replace($search, $replace, $jd);
		$jf = str_replace($search, $replace, $jf);
	$search  = array('01', '02', '03', '04', '05','06','07','08','09','10','11','12');
	$replace = array('janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre');
	$md = str_replace($search, $replace, $md);
	$mf = str_replace($search, $replace, $mf);
//comparaison des deux dates 
if ($md = $mf){
	$aff_periode = $jd." au ".$jf." ".$mf;
	}
	else{
	$aff_periode = $jd." ".$md." au ".$jf." ".$mf;
	}
	

$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());

/*======================================
Calcul des moyennes sur la période concernée de chaque élève pour déterminer le classement */

$sql = "SELECT * FROM Periodes WHERE Nomperiode = '$periode'";
$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));
while($data_a = mysql_fetch_assoc($req_a))
	{
		$debut = $data[Debutperiode];
		$fin = $data[Finperiode];
	}




$sql = "SELECT * FROM Classes WHERE Classe = '$classe' ORDER BY Nom";
$req_a = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));

/*++++++++++++++++
Début de la boucle générale */
$k = 1;
while($data_a = mysql_fetch_assoc($req_a))
	{
		$index[$k] = $data_a['Indexs'];
		$eleve = $index[$k];		
		$k += 1;


	/*----------------
	 Extraction des prénom, nom de l'élève */
	$sql = "SELECT * FROM Classes WHERE Indexs = '$eleve'";
	$connexion = mysql_connect($serveur, $user, $password) or die("Impossible de se connecter : ".mysql_error());
	mysql_select_db($db, $connexion) or die("Impossible d'ouvrir $db : ".mysql_error());
	/* mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $connnexion); */
	$req = mysql_query($sql, $connexion) or die('Erreur SQL !'.$sql.'<br>'.mysql_error($connexion));

	while($data = mysql_fetch_assoc($req))
		{
			$prenom = $data[Prenom];
			$nom = $data[Nom];
		}


	/*======================
		ENTETE		*/

?>
	<IMG SRC="style/gavrus.jpg" align=left
		WIDTH=35%
		ALT="Texte remplaçant l'image"
 		TITLE="Texte à afficher"
 		VSPACE=10px>

	<font size='5'><center><b>	
			<?php echo "$ecole";?> 
	</b></center></font><br><br>

	<font size='3'><b>
	<table class="style2" width=100% border="0"><tr><td> </td></tr></table>
	<table class="style2" width=600 border="0">
		<tr><td><?php echo utf8_encode("$prenom $nom");?></td>
		<td align=right>Classe de <?php echo "$classe";?></td></tr>
	</table>	
		<p style="margin-top:1em ; margin-bottom:1em ; text-align: center">
			Période du <?php echo "$aff_periode";?>  
		</p>
	</b></font>	
	
<?php

	/*======================
		NOTES		*/

	/*---------------------
	 On rassemble les notes de cet élève */
	$TabNotes1 = array(); /* Cet Array sera un tableau contenant les notes de l'élève, matière par matière */
	$TabNotes2 = array();
	$TabNotes3 = array();

	$sql = "SELECT * FROM Matieres
			LEFT JOIN Notes ON Matieres.IndMat=Notes.IndMat2
			WHERE (Matieres.Classe='$classe' AND IndEleve='$eleve' AND Periode='$periode')
			OR (Matieres.Classe='$classe' AND IndEleve IS NULL)
			ORDER BY Tri";
	$req = mysql_query($sql, $connexion) or die('Erreur SQL ! '.$sql.'<br>'.mysql_error());
	
	$sqli = "SELECT * FROM Matieres
			WHERE Classe='$classe'";
	$reqi = mysql_query($sqli, $connexion) or die('Erreur SQL ! '.$sqli.'<br>'.mysql_error());
	$nummat = mysql_num_rows($reqi);
	
	$somme = 0;
	$nombre = 0;
	$search  = array('/', '.');
	$replace = array(' ', ',');
	$i=1;
	while($data = mysql_fetch_assoc($req))
		{
			$matiere = $data[Matiere];
			$IndMat = $data[IndMat];
			$type = $data[type];
			$IndType = $data[IndType];
			$Note = str_replace($search , $replace , $data[Note]);
			$somme = $somme + $data[somme];
			$nombre = $nombre + $data[nombre];
			$TitMat[$IndMat] = $data[MatiereAff];
			$arrayIndMat[$IndMat] = $data[IndMat];
			
			switch($IndType) 
	 			{
	 				case 1:
	 				$TabNotes1[$IndMat] = $Note;
	 				break;
	 				case 2:
	 				$TabNotes2[$IndMat] = $Note;
	 				break;
	 				case 3:
	 				$TabNotes3[$IndMat] = $Note;
	 				break;
	 			}
	 	} 
			
	/*--------------------
	 Affichage de TabNotes pour un élève donné*/	

	?>
	<table class="style1" border="1" cellpadding=2><tr><th></th><th>Contrôle</th><th>Ecrit</th><th>Oral</th></tr>
	<tr>
	<?php	
	$arrayIndMat1=array_slice($arrayIndMat,0,$nummat-4);
	foreach($arrayIndMat1 as $d)
		{
			?>
			<td width="200"><?php echo utf8_encode($TitMat[$d]) ?></td><td width="150">
			<?php echo "$TabNotes1[$d]"; ?></td><td width="200">
			<?php echo "$TabNotes2[$d]"; ?></td><td width="200">
			<?php echo "$TabNotes3[$d]"; ?></td>
			</tr>
			<?php
		}

?>
	</table><br><br>
	
	


	<!-- ===============
	Retards, appréciations, signatures…*/-->
	
	<table class="style1" border="1" align="left" cellpadding=2>
	
<?php
	$arrayIndMat2=array_slice($arrayIndMat,$nummat-4);
	foreach($arrayIndMat2 as $l)
		{	
			?>
			<tr><td width="170"><?php echo utf8_encode($TitMat[$l]) ?></td><td width="30">
			<?php echo "$TabNotes1[$l]"; ?></td>
			</tr>
			<?php
		}
?>	
	</table>

		
	<!---------------
		Moyenne et classement-->
	<?php $moyenne = str_replace('.',',', round($somme/$nombre,2)); 
	$placement = calcul($eleve); /* appel de la fonction calcul qui donne le classement	*/
	?>
	<font size='3'><b>
	<table class="style1" border="1" align="right" cellpadding=10>
	<tr><td width="130">Moyenne</td><td width="30" align="center"><?php echo "$moyenne" ?></td>
	<tr><td>Classement</td><td align="center"><?php echo $placement ?></td>
	</table>
	</b></font>
	
	<!----------->
	<p style="margin-top:7em ; margin-bottom:6em"> <font size='3'><b> Observations </b></font> 
	</p>
	
	<font size='3'><b>
	<table width=100% class="ssbords">
	<tr><td ALIGN="center"> Signature du directeur </td>
		<td ALIGN="center"> Signature des parents </td></tr>
	</table>
	</b></font>
		<br><br><br>
	
<?php

	/*Saut de page*/
?>	
	<div style="page-break-before: always;">
	</div>
<?php

/*++++++++++++++++
Fin de la boucle générale */
}
mysql_close();  // on ferme la connexion

?>

</body></html>
