<?php
//Récupération d'une connexion à la base de données
$connexion = getPDO();

$sql = "SELECT * FROM personnes";
$resultat = $connexion->query($sql);

//var_dump($resultat);
//var_dump($resultat->fetch(PDO::FETCH_ASSOC));
//var_dump($resultat->fetch(PDO::FETCH_ASSOC));

//Récupération ligne à ligne
while(($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) !== false){
    echo $ligne["prenom"]." ".$ligne["nom"]."<br>";
}

//Récupération globale
$resultat = $connexion->query($sql);
$donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);
$nbPersonnes = count($donnees);
var_dump($donnees);
echo "<br>Il y a ".$nbPersonnes." personnes";

//Suppression des inscriptions de la personne dont l'id=1
$sql ="DELETE FROM inscription_formation WHERE personne_id=1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime inscriptions supprimées</p>";

//Suppression des notes de la personne dont l'id=1
$sql ="DELETE FROM notes WHERE personne_id=1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime notes supprimées</p>";

//Suppression des ventes de la personne dont l'id=1
$sql ="DELETE FROM ventes WHERE vendeur_id=1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime ventes supprimées</p>";

//Supression de la personne dont l'id=1
$sql = "DELETE FROM personnes WHERE personne_id=1";
$nbSupprime = $connexion->exec($sql);
echo "<p>$nbSupprime personnes supprimées</p>";

//Exécution d'une procédure stockée
$sql = "CALL proc_insert_personne_pdo('Gallois','Evariste','1623-12-01')";
$connexion->exec($sql);

//Récupération de l'identifiant de la personne créée
$id = $connexion->lastInsertId();
//Requête pour vérifier l'insertion des données
$sql = "SELECT * FROM personnes WHERE personne_id=$id";
$resultat = $connexion->query($sql);
var_dump($resultat->fetch(PDO::FETCH_ASSOC));