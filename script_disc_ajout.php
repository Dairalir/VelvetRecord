<?php

    function getParameter($name, $type = FILTER_DEFAULT) {
        $param = $_POST[$name];

        return !empty($param)
            ? validateData($param, $type)
            : null;
    }

    function validateData($donnees, $type){
        $donnees = trim($donnees);
        $donnees = stripslashes($donnees);
        $donnees = htmlspecialchars($donnees);

        return filter_var($donnees, $type);
    }

    // Récupération de l'URL (même traitement, avec une syntaxe abrégée)
    $titre =   getParameter("titre");
    $annee =   getParameter("annee", FILTER_VALIDATE_INT);
    $image =   getParameter("image");
    $label =   getParameter("label");
    $genre =   getParameter("genre");
    $prix =    getParameter("prix", FILTER_VALIDATE_INT);
    $artiste = getParameter("artiste");


    // En cas d'erreur, on renvoie vers le formulaire
    if ($titre == null || $annee == null || $image == null || $label == null || $genre == null || $prix == null || $artiste == null) {
        header("Location: disc_new.php");
        exit;
    }

    // S'il n'y a pas eu de redirection vers le formulaire (= si la vérification des données est ok) :
    require "db.php"; 
    $db = connexionBase();

try {
    // Construction de la requête INSERT sans injection SQL :
    $requete = $db->prepare("INSERT INTO disc (disc_title, disc_year, disc_picture, disc_label, disc_genre, disc_price, artist_id) VALUES (:titre, :annee, :image, :label, :genre, :prix, :artiste);");

    // Association des valeurs aux paramètres via bindValue() :
    $requete->bindValue(":titre", $titre, PDO::PARAM_STR);
    $requete->bindValue(":annee", $annee, PDO::PARAM_STR);
    $requete->bindValue(":image", $image, PDO::PARAM_STR);
    $requete->bindValue(":label", $label, PDO::PARAM_STR);
    $requete->bindValue(":genre", $genre, PDO::PARAM_STR);
    $requete->bindValue(":prix", $prix, PDO::PARAM_STR);
    $requete->bindValue(":artiste", $artiste, PDO::PARAM_STR);

    // Lancement de la requête :
    $requete->execute();

    // Libération de la requête (utile pour lancer d'autres requêtes par la suite) :
    $requete->closeCursor();
}

// Gestion des erreurs
catch (Exception $e) {
    var_dump($requete->queryString);
    var_dump($requete->errorInfo());
    echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
    die("Fin du script (script_disc_ajout.php)");
}

// Si OK: redirection vers la page discs.php
header("Location: discs.php");

// Fermeture du script
exit;
?>