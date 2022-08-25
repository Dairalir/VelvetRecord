<?php
    include "db.php";

    $db = connexionBase();

    $requete = $db->query("SELECT * FROM artist"); //requete SQL
    $myartist = $requete->fetchAll(PDO::FETCH_OBJ);
    $requete->closeCursor();
?>

<?php 
    include("header.php");
?>

    <h1>Ajouter un vinyle</h1>

    <br>
    <br>

    <form action ="script_disc_ajout.php" method="post">

        <label for="titre_for_label">Title :</label><br>
        <input type="text" name="titre" id="titre_for_label" required pattern="^[A-Za-z '-]+$">
        <br><br>

        <label for="artiste_for_label">Artiste :</label><br>
        <select name="artiste" id="artiste_for_label">
            <?php foreach ($myartist as $artist): ?>
            <option value="<?= $artist->artist_id ?>"><?= $artist->artist_name ?></option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="annee_for_label">Year :</label><br>
        <input type="text" name="annee" id="annee_for_label" maxlength="4">
        <br><br>

        <label for="genre_for_label">Genre :</label><br>
        <input type="text" name="genre" id="genre_for_label" required pattern="^[A-Za-z '-]+$">
        <br><br>

        <label for="label_for_label">Label :</label><br>
        <input type="text" name="label" id="label_for_label" required pattern="^[A-Za-z '-]+$">
        <br><br>

        <label for="prix_for_label">Price :</label><br>
        <input type="text" name="prix" id="prix_for_label">
        <br><br>

        <label for="image_for_label">Picture :</label><br>
        <input type="file" name="image" id="image_for_label" accept="image/png, image/jpeg">
        <br><br>

        <input type="submit" value="Ajouter">

    </form>
    <a href="discs.php"><button>Retour</button></a>

<?php 
include("footer.php");
?>