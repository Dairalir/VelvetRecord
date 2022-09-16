<?php 
    include("header.php");
?>

<?php
require('db.php');
$db = connexionBase();

session_start();
if (isset($_POST['username'])){
    $username = stripslashes($_REQUEST['username']);
    $password = stripslashes($_REQUEST['password']);
    $query = "SELECT * FROM `users` WHERE username='$username' and password='".hash('sha256', $password)."'";
    $result = $db->query($query) or die();
    $rows = count($result->fetchAll());
    if($rows==1){
        $_SESSION['username'] = $username;
        header("Location: discs.php");
    }else{
    $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>
<form class="box" action="" method="post" name="login">
<h1 class="box-title">Connexion</h1>
<input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur">
<input type="password" class="box-input" name="password" placeholder="Mot de passe">
<input type="submit" value="Connexion " name="submit" class="box-button">
<p class="box-register">Vous êtes nouveau ici? <a href="register.php">S'inscrire</a></p>
<?php if (! empty($message)) { ?>
    <p class="errorMessage"><?php echo $message; ?></p>
<?php } ?>
</form>

<?php 
    include("footer.php");
?>