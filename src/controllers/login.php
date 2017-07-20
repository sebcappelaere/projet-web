<?php
use m2i\web\User;

//Initialisation du tableau des erreurs
$errors = [];

//Récupération des données postées
$login = filter_input(INPUT_POST,'login',FILTER_SANITIZE_STRING);
$password = filter_input(INPUT_POST,'password',FILTER_SANITIZE_STRING);
$isSubmitted = filter_has_var(INPUT_POST,'submit');


if($isSubmitted){
    //Validation des données
    if(empty($login)){
        $errors[] = "Vous devez saisir un identifiant";
    }
    if(empty($password)){
        $errors[] = "Vous devez saisir un mot de passe";
    }
    //Traitement des données
    //s'il n'y a pas d'erreurs
    if(count($errors)==0){
        //Connexion à la base de données pour vérifier l'authentification
        $connexion = getPDO();
        $user = new User();

        if($user->loadUser($connexion, $login, $password)){
            //Stockage de l'utilisateur en session
            $_SESSION["user"] = serialize($user);

            $redirections = [
                "ADMIN" => "accueil-admin",
                "STAGIAIRE" => "accueil-stagiaire",
                "FORMATEUR" => "accueil-formateur"
            ];

            $cible = $redirections[$user->getRole()] ?? "accueil";

            //Redirection
            header("location:index.php?controller=$cible");
        } else {
            $errors[] = "Vos informations d'identification sont incorrectes";
        }
    }
    
}

//Affichage du formulaire
renderView('login',
    [
        'errors' => $errors,
        'login' => $login,
        'pageTitle' => "Login administration"
    ]
);

?>