<?php 
    include("header.php");
?>
<?php
    // On se connecte à la BDD via notre fichier db.php :
    require "db.php";
    $db = connexionBase();

    if (isset($_REQUEST['username'], $_REQUEST['email'], $_REQUEST['password'])){
        // récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
        $username = stripslashes($_REQUEST['username']);
        // récupérer l'email et supprimer les antislashes ajoutés par le formulaire
        $email = stripslashes($_REQUEST['email']);
        // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
        $password = stripslashes($_REQUEST['password']);
        //requéte SQL + mot de passe crypté
        $query = "INSERT into `users` (username, email, password)
                    VALUES ('$username', '$email', '".hash('sha256', $password)."')";
        // Exécuter la requête sur la base de données
        $res = $db->query($query);
        if($res){
            echo "<div class='sucess'>
                <h3>Vous êtes inscrit avec succès.</h3>
                <p>Cliquez ici pour vous <a href='login.php'>connecter</a></p>
            </div>";
        }
    }else{
    ?>
    <form class="box" action="" method="post">
        <h1 class="box-title">S'inscrire</h1>
        <input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required />
        <input type="text" class="box-input" name="email" placeholder="Email" required />
        <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
        <input type="submit" name="submit" value="S'inscrire" class="box-button" />
        <p class="box-register">Déjà inscrit? <a href="login.php">Connectez-vous ici</a></p>
    </form>
    <?php } 
    ?>
<?php 
    include("footer.php");
?>