    <!DOCTYPE html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Login | ClickExchange </title>
    <link href="./assets/login.css" rel="stylesheet">
    <meta name="author" content="BEOSMO" />
    <meta name="revisit-after" content="15" />
    <meta name="language" content="FR" />
    <meta name="copyright" content="2020" />
    
    <meta name="description" content="ClickExchange est un site qui permet d'augmenter les vues sur vos liens. (Echange de traffic gratuit et illimité !)" />
    <meta name="abstract" content="" />
    <meta name="keywords" content="traffic,lien,link,click,exchange,clickexchange,gratuit,free,boost,illimité,echange,paypal,clictune,url,clickurl" />
       
    <meta name="theme-color" content="#005A82">
    <link rel="icon" type="image/x-icon" href="favicon.ico" />

    </head>
    <body>
<?php require './inc/config.php'; ?>
    
<?php if ($_SESSION['id']==0) { ?>





<div id="contenu">
<div style="margin-top:120px;"></div>
<div id="logo">Clickexchange</div>
<center><small>Pour accéder à notre service, merci de vous connectez. </small></center>
<div style="margin-top:15px"></div>
    <a href="https://auth.sayme.app?auth=(CODE)" id="sayme">Connexion avec SAYME </a>
</div>    
   
   
   
   
    
<?php } else { echo '<meta http-equiv="refresh" content="0; URL=dash" />'; }

//à insèrer sur la page connexion
if(isset($_GET['auth_sayme'])){

$readjson = file_get_contents('https://auth.sayme.app/data.php?auth='.$_GET['auth_sayme']) ;
$data = json_decode($readjson, true);

foreach ($data as $emp) {

$access = $emp['access'];

if ($access=="true")
{
$username = $emp['name'];      $email = $emp['email'];      $avatar = $emp['avatar'];

$search_user = $bdd->prepare('SELECT * FROM users WHERE email = ?');
$search_user->execute(array($email));

if($search_user->rowCount() == 0) {

$add_user = $bdd->prepare("INSERT INTO users (username,email,avatar) VALUES (?,?,?)");
$add_user->execute(array($username,$email,$avatar));

$select_user = $bdd->prepare('SELECT * FROM users WHERE email = ?');
$select_user->execute(array($email));

$data_user = $select_user->fetch();

$_SESSION['id'] = $data_user['id'];

$logs=$bdd->prepare('INSERT INTO logs (userid,type,description,ip,`date`) VALUES (?,?,?,?,?)');
$logs->execute(array($_SESSION['id'],"connexion","Première connexion",$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s')));

echo '<meta http-equiv="refresh" content="0; URL=dash" />';

}
else
{
$select_user = $bdd->prepare('SELECT * FROM users WHERE email = ?');
$select_user->execute(array($email));

$data_user = $select_user->fetch();

$_SESSION['id'] = $data_user['id'];

$update_avatar = $bdd->prepare('UPDATE users SET avatar = ?, email = ? WHERE id = ?');
$update_avatar->execute(array($avatar,$email,$data_user['id']));

$logs=$bdd->prepare('INSERT INTO logs (userid,type,description,ip,`date`) VALUES (?,?,?,?,?)');
$logs->execute(array($_SESSION['id'],"connexion","Connexion à votre compte",$_SERVER['REMOTE_ADDR'],date('Y-m-d H:i:s')));



echo '<meta http-equiv="refresh" content="0; URL=dash" />';

}

}
if ($access=="false")
{
echo 'erreur';
}
}
}
    
?>

    </body>
    </html>
