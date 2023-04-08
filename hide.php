<?php
      require('inc/config.php');
        $_GET['id'] = htmlspecialchars($_GET['id']);
        $sql_delcomms = $bdd->prepare("UPDATE link SET hide = '1' WHERE id = ?");
	$sql_delcomms->execute(array($_GET['id']));
	
   $saveinlogs = $bdd->prepare('INSERT INTO logs (userid,type,description,ip,`date`) VALUES (?,?,?,?,?)');
   $saveinlogs->execute(array($_SESSION['id'],"hidetransaction","Un lien a été masqué.",$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s')));
	
	header("Location: dash");
?>
