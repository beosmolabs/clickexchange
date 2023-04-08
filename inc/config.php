<?php
date_default_timezone_set('Europe/Paris');	
session_start();
ob_start();

if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
  $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
}

try {
	$bdd = new PDO('mysql:host=localhost;dbname=database', 'user', 'password');

	date_default_timezone_set('Europe/Paris');

	if($_SESSION['id'] != 0) {
		$get_UserData = $bdd->prepare('SELECT * FROM users WHERE id = ?');
		$get_UserData->execute(array($_SESSION['id']));

		$myData = $get_UserData->fetch(PDO::FETCH_ASSOC);

		// Mise à jour des données
		$upUserData = $bdd->prepare('UPDATE users SET last_date = ?, last_ip = ? WHERE id = ?');
		$upUserData->execute(array(date('Y-m-d H:i:s'),$_SERVER['REMOTE_ADDR'],$myData['id']));
	}
	else {
		$_SESSION['id'] = intval(0);
	}


} catch ( Exception $e ) {
  echo "<h2>Erreur de connexion avec la base de données.<br>Essayez d'actualiser la page.</h2> "/*, $e->getMessage()*/;
  die();
}

?>

