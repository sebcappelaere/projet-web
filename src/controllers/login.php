<?php
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
        $sql = "SELECT CONCAT_WS(' ',p.prenom,p.nom) as username,u.role_utilisateur 
                FROM utilisateurs as u INNER JOIN personnes as p ON p.personne_id=u.personne_id 
                WHERE u.email=? AND u.mot_de_passe=?";
        $stm = $connexion->prepare($sql);
        $stm->execute([$login, sha1($password)]);
        $rs = $stm->fetch(PDO::FETCH_ASSOC);

        $ok = count($rs) > 0;

        if($ok){
            $_SESSION["role"] = $rs["role_utilisateur"];
            $_SESSION["userName"] = $rs["username"];

            $redirections = [
                "ADMIN" => "accueil-admin",
                "STAGIAIRE" => "accueil-stagiaire",
                "FORMATEUR" => "accueil-formateur"
            ];

            $cible = $redirections[$rs["role_utilisateur"]] ?? "accueil";

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