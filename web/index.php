<?php

//Récupération du contrôleur
//avec gestion de la page de défaut
if(isset($_GET["controller"])){
    $controllerName = $_GET["controller"];
} else {
    $controllerName = "accueil";
}
//Définition du dossier racine du projet (ici le projet web)
define("ROOT_PATH",dirname(__DIR__));

//Inclusion de dépendance du projet
require ROOT_PATH.'/src/framework/mvc.php';

//Définition du chemin du contrôleur
$controllerPath = ROOT_PATH.'/src/controllers/'.$controllerName.'.php';

//Test de l'existence du contrôleur
if(!file_exists($controllerPath)){
    //Envoie vers le fichier erreur
    $controllerPath = ROOT_PATH.'/src/controllers/erreur.php';
}

//Exécution du contrôleur
require $controllerPath;



?>