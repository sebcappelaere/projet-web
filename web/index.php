<?php
//Démarrage de la session
session_start();

//Définition du dossier racine du projet (ici le projet-web)
define("ROOT_PATH",dirname(__DIR__));

//Inclusion du fichier d'autochargement de composer
require ROOT_PATH."/vendor/autoload.php";

//Inclusion de dépendance du projet
require ROOT_PATH.'/src/framework/mvc.php';
require ROOT_PATH.'/src/config/config.php';

//Enregistrement des fonctions d'autochargement des classes
//spl_autoload_register("autoloader");

//Instanciation de klogger
$logger = new Katzgrau\KLogger\Logger(ROOT_PATH."/logs");

//Récupération du contrôleur
//avec gestion de la page de défaut
if(isset($_GET["controller"])){
    $controllerName = $_GET["controller"];
} else {
    $controllerName = "accueil";
}

//Sécurisation de l'accès aux utilisateurs authorisés
//Regénération d'un nouvel id de session à chaque fois
session_regenerate_id(true);

$securedRoutes = [
    'accueil-admin' => 'ADMIN',
    'accueil-formateur' => 'FORMATEUR',
    'accueil-stagiaire' => 'STAGIAIRE'
];

//Gestion de l'utilisateur avec la POO
$user = getUser();
$role = $user->getRole();
//Si on tente d'acceder à une page sécurisée sans s'être identifié au préalable
//alors la route est modifiée pour afficher le formulaire de login
if (array_key_exists($controllerName, $securedRoutes) && $role != $securedRoutes[$controllerName]) {
    $_SESSION["flash"] = "Vous n'avez pas les droits pour accéder à cette page, veuillez vous identifier";
    //$controllerName = "login"; Ici le nom ds l'url ne serait pas modifié
    header("location:index.php?controller=login");
    exit;
}

//Définition du chemin du contrôleur
$controllerPath = ROOT_PATH.'/src/controllers/'.$controllerName.'.php';

//Test de l'existence du contrôleur
if(!file_exists($controllerPath)){
    //Envoie vers le fichier erreur
    $controllerPath = ROOT_PATH.'/src/controllers/erreur.php';
}

$logger->info("Lancement de l'application");

//Exécution du contrôleur
require $controllerPath;



?>