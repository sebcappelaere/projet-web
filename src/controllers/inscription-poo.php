<?php

//Inclusion de la classe
//require_once ROOT_PATH."/src/classes/Inscription.php";
use m2i\web\Inscription;

//Instanciation de la classe
//avec injection des données du formulaire
$pdo = getPDO();
$inscription = new Inscription($_POST, $pdo);

if ($inscription->isFormSubmitted()){
    try {
        $inscription->handleRequest();

        if (!$inscription->hasErrors()){
            //Redirection vers la page d'accueil
            $_SESSION["flash"] = "Vous êtes inscrit vous pouvez maintenant vous identifier";
            header("location:index.php?controller=accueil");
            exit;
        }
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION["flash"] = "Impossible de traiter les données";
    }
}

//Affichage de la vue
renderView(
    "inscription",
    [
        "pageTitle" => "Inscription",
        "errors" => $inscription->getErrors()
    ]
);