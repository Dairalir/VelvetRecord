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
    $id =      getParameter("id");
    $titre =   getParameter("titre");
    $annee =   getParameter("annee", FILTER_VALIDATE_INT);
    $image =   getParameter("image");
    $label =   getParameter("label");
    $genre =   getParameter("genre");
    $prix =    getParameter("prix", FILTER_VALIDATE_INT);
    $artiste = getParameter("artiste");
    
    // En cas d'erreur, on renvoie vers le formulaire
    if ($titre == null || $annee == null || $image == null || $label == null || $genre == null || $prix == null || $artiste == null) {
        header("Location: disc_form.php?id=" . $id);
        exit;
    }
        
    // Si la vérification des données est ok :
    require "db.php"; 
    $db = connexionBase();

    try {
    // Construction de la requête UPDATE sans injection SQL :
    $requete = $db->prepare("UPDATE disc SET disc_title = :titre, disc_year = :annee, disc_picture = :image, disc_label = :label, disc_genre = :genre, disc_price = :prix, artist_id = :artiste WHERE disc_id = :id;");
    $requete->bindValue(":titre", $titre, PDO::PARAM_STR);
    $requete->bindValue(":annee", $annee, PDO::PARAM_STR);
    $requete->bindValue(":image", $image, PDO::PARAM_STR);
    $requete->bindValue(":label", $label, PDO::PARAM_STR);
    $requete->bindValue(":genre", $genre, PDO::PARAM_STR);
    $requete->bindValue(":prix", $prix, PDO::PARAM_STR);
    $requete->bindValue(":artiste", $artiste, PDO::PARAM_STR);

    $requete->execute();
    $requete->closeCursor();
    }

    catch (Exception $e) {
        echo "Erreur : " . $requete->errorInfo()[2] . "<br>";
        die("Fin du script (script_disc_modif.php)");
    }

    // Si OK: redirection vers la page artist_detail.php
    header("Location: disc_detail.php?id=" . $id);
    exit;
    ?>