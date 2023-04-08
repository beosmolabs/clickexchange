<?php
    include('inc/config.php');
    session_start();
	ob_start();
    $saveinlogs = $bdd->prepare('INSERT INTO logs (userid,type,description,ip,`date`) VALUES (?,?,?,?,?)');
    $saveinlogs->execute(array($_SESSION['id'],"account","Déconnexion du compte",$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s')));
	unset($_SERVER['id']);
    setcookie('PHPSESSID','valeur',time()+365*24*3600);//permet de créer un cookie qui expire (et donc se supprime) 1 an à compter de la date (et de l'heure) de création du cookie.
    setcookie('PHPSESSID','',time());//permet de créer un cookie qui expire au moment de sa création.
	session_destroy();
	ob_end_clean();

	header('Location: ./');
	exit();
	die();
?>


