<?php

//Récupération de la liste des compétences
//Chemin vers le fichier json
$filePath = ROOT_PATH. '/src/data/competences.json';
//Récupération des données sous la forme d'un tableau
$data = json_decode(file_get_contents($filePath),true);

//var_dump($data);

renderView(
    'accueil-admin',
    [
        'pageTitle' => "Espace Administration",
        'skills' => $data['skills']
    ]
);
    
//Ajout d'une nouvelle compétence ds le tableau
//Récupération de la compétence entrée ds le formulaire
$newCompetence = filter_input(INPUT_POST,'newCompetence',FILTER_SANITIZE_STRING);
$isSubmitted = filter_has_var(INPUT_POST,'valid');

if ($isSubmitted){
    //Validation des données si compétence n'est pas vide et n'existe pas déjà ds le tableau
    if (!empty($newCompetence) && !in_array($newCompetence,$data['skills'])){ 
    //Ajout de la compétence 
        $data['skills'][] = $newCompetence;
        file_put_contents($filePath, json_encode($data));
    }
    //Redirection pr éviter de reposter les données
    header("location:index.php?controller=accueil-admin");
}

//Supression d'une compétence
$itemIndex = filter_input(INPUT_GET,'itemIndex', FILTER_VALIDATE_INT);

if($itemIndex >0){
    //suppression de la compétence dans le tableau
     array_splice($data["skills"], $itemIndex-1,1);
     //Mise à jour de la source de données
    file_put_contents($filePath, json_encode($data));

    //Redirection pour éviter de reposter les données
    header("location:index.php?controller=accueil-admin");

}