<?php
//Récupération du contrôleur
$controllerName = $_GET["controller"];

//Définition du dossier racine du projet (ici le projet web)
define("ROOT_PATH",dirname(__DIR__));

var_dump(ROOT_PATH);

//Exécution du contrôleur
require ROOT_PATH.'/src/controllers/'.$controllerName.'.php';
?>