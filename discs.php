<?php
    include "db.php";

    $db = connexionBase();

    $requete = $db->query("SELECT * FROM artist JOIN disc ON artist.artist_id = disc.artist_id"); //requete SQL
    $tableau = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
    $count = $db->query("SELECT COUNT(disc_id) FROM disc");
    $result = $count->fetchColumn(); //recupère le nombre de ligne
    $count->closeCursor();

    // Initialiser la session
    session_start();
    // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
    if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit(); 
    }
?>

<?php 
    include("header.php");
?>

<a href="logout.php">Déconnexion</a>

<h1>Liste des disques (<?= $result ?>)</h1>
<a href="disc_new.php"><button type="button" class="btn btn-primary"> Ajouter </button></a>
    <table>
        <?php foreach ($tableau as $disc): ?>
        <tr>
            <td><img src="src/jaquettes/<?= $disc->disc_picture ?>" width="300px"></td> <!-- Utiliser les données dans la bdd lié aux noms des images -->
            <td><b><?= $disc->disc_title ?></b><br>
            <b><?= $disc->artist_name ?></b><br>
            <b>Label : </b><?= $disc->disc_label ?><br>
            <b>Year : </b><?= $disc->disc_year ?><br>
            <b>Genre : </b><?= $disc->disc_genre ?><br>
            <!-- Ici, on ajoute un lien par artiste pour accéder à sa fiche : -->
            <a href="disc_detail.php?id=<?= $disc->disc_id ?>"><button type="button" class="btn btn-outline-primary">Détails</button></a></td>
        </tr>
        <?php endforeach; ?>

    </table>
    <?php 
    include("footer.php");
?>