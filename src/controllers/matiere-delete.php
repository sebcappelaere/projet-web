<?php

//Récupération du paramètre id
$id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

//Exécution de la requête de suppression
try {
    $connexion = getPDO();
    $sql = "DELETE FROM matieres WHERE matiere_id=?";
    $statement = $connexion->prepare($sql);
    $statement->execute([$id]);
} catch(PDOException $e){
    $_SESSION["flash"] = "Impossible de supprimer cette matière";
}


//Redirection vers le contrôleur matieres
header("location:index.php?controller=matieres");