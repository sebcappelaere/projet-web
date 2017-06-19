<?php
/**
@param string $view : le nom de la vue
@param array $data : un tableau des données passées à la vue
@return string : le code html de la vue
*/
function getTemplate(string $view,array $data=[]){
    //mise en tampon du résultat de l'interprétation PHP
    //N'envoie pas de réponse HTTP implicite
    ob_start();
    //Transformation du tableau associatif des données
    //en une suite de variables
    extract($data);
    //Inclusion du fichier de la vue ds le tampon
    require ROOT_PATH."/src/views/{$view}.php";
    //Récupération du contenu du tampon ds une variable
    $content= ob_get_clean();

    return $content;
}

/**
Affiche le résultat d'une vue décorée par un gabarit
@param string $view : le nom de la vue
@param array $data : un tableau associatif des données passées à la vue
@param string $layout : le gabarit qui décorera la vue
*/
function renderView(
    string $view,
    array $data=[],
    string $layout="gabarit"){
        //Récupération du code html(interpolé) de la vue
        $viewContent = getTemplate($view,$data);
        //Ajout du rendu de la vue aux données passées au gabarit
        $data["content"] = $viewContent;
        //Application du gabarit
        $result = getTemplate($layout,$data);

        echo $result;
}

/**
Fonction de connexion à une base de données avec la bibliothèque PDO
@return PDO
*/
function getPDO(){
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    return new PDO(DSN,DB_USER,DB_PASS, $options);
}
