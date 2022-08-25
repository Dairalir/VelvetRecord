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

<?php 
    include("header.php");
?>
    <body>
    <b>Title : </b> <?= $myDisc->disc_title ?>
    <b>Artist : </b> <?= $myDisc->artist_name ?><br>
    <b>Year : </b> <?= $myDisc->disc_year ?>
    <b>Genre : </b> <?= $myDisc->disc_genre ?><br>
    <b>Label : </b> <?= $myDisc->disc_label ?>
    <b>Price : </b> <?= $myDisc->disc_price ?><br>
        <img src="src/jaquettes/<?= $myDisc->disc_picture ?>" width="300px"><br>
        
        <a href="disc_form.php?id=<?= $myDisc->disc_id ?>"><button>Modifier</button></a>
        <a href="script_disc_delete.php?id=<?= $myDisc->disc_id ?>" id="delete"><button> Supprimer</button></a>

    <a href="discs.php"><button>Retour</button></a>

    <?php 
    include("footer.php");
?>