<?php
    // On se connecte à la BDD via notre fichier db.php :
    require "db.php";
    $db = connexionBase();

    // On récupère l'ID passé en paramètre :
    $id = $_GET["id"];

    // On crée une requête préparée avec condition de recherche :
    $requete = $db->prepare("SELECT * FROM disc JOIN artist ON disc.artist_id = artist.artist_id WHERE disc_id=?");
    // on ajoute l'ID du disque passé dans l'URL en paramètre et on exécute :
    $requete->execute(array($id));

    // on récupère 1e (et seul) résultat :
    $myDisc = $requete->fetch(PDO::FETCH_OBJ);

    // on clôt la requête en BDD
    $requete->closeCursor();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Details disque</title>
    </head>
    <body>
        Title <?= $myDisc->disc_title ?>
        Artist <?= $myDisc->artist_name ?><br>
        Year <?= $myDisc->disc_year ?>
        Genre <?= $myDisc->disc_genre ?><br>
        Label <?= $myDisc->disc_label ?>
        Price <?= $myDisc->disc_price ?><br>
        <img src="src/jaquettes/<?= $myDisc->disc_picture ?>" width="300px"><br>
        
        <a href="disc_form.php?id=<?= $myDisc->disc_id ?>"><button>Modifier</button></a>
        <a href="script_disc_delete.php?id=<?= $myDisc->disc_id ?>" id="delete"><button> Supprimer</button></a>

    <a href="discs.php"><button>Retour</button></a>

    <script src="assets/js/script.js"></script>
    </body>
</html>