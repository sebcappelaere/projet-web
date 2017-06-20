<?php

//Requête pour récupérer toutes les lignes de la table matieres
$connexion = getPDO();
$sql = "SELECT * FROM matieres";
$resultat = $connexion->query($sql);
$listeMatieres = $resultat->fetchAll(PDO::FETCH_ASSOC);

//Affichage de la vue
renderView(
    'matieres',
    [
        'pageTitle' => 'Liste des matières',
        'listeMatieres' => $listeMatieres
    ]
);