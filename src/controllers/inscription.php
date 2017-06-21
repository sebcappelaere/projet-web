<?php
//Test de la soumission du formulaire
$isSubmitted = filter_has_var(INPUT_POST, "submit");

//Initialisation d'un tableau des erreurs
$errors = [];

if ($isSubmitted) {
    $connexion = getPDO();

    //Récupération des données
    $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
    $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_STRING);
    $mdpConfirm = filter_input(INPUT_POST, 'confirmation-mdp', FILTER_SANITIZE_STRING);

    //Validation des données
    if (empty($nom)) {
        $errors[] = "Vous devez saisir un nom";
    }
    if (empty($email)) {
        $errors[] = "Vous devez saisir un email";
    }

    if (empty($mdp)) {
        $errors[] = "Vous devez saisir un mot de passe";
    }
    if ($mdp != $mdpConfirm) {
        $errors[] = "Le mot de passe et sa confirmation doivent être identiques";
    }

    //Exécution des requêtes avec capture des exceptions
    try {
        //Validation des règles métier seulement si la saisie est valide
        if (count($errors) == 0) {
            //Présence d'un email dans la table utilisateurs
            $sql = "SELECT email FROM utilisateurs WHERE email=?";
            $stm = $connexion->prepare($sql);
            $stm->execute([$email]);
            if (count($stm->fetchAll(PDO::FETCH_ASSOC))) {
                $errors[] = "Cette adresse email est déjà utilisée";
            }//Fin test email

            //Personne existante dans la table des utilisateurs
            $sql = "SELECT p.personne_id FROM personnes as p INNER JOIN utilisateurs as u
                ON p.personne_id=u.personne_id
                WHERE p.nom=? and p.prenom =?";
            $stm = $connexion->prepare($sql);
            $stm->execute([$nom, $prenom]);
            if (count($stm->fetchAll(PDO::FETCH_ASSOC))) {
                $errors[] = "Vous vous êtes déjà inscrit en tant qu'utilisateur";
            }//fin test personne
        }//Fin validation des règles métier

        //S'il n'y a pas d'erreurs, insertion des données
        if (count($errors) == 0) {
            //Insertion de la personne ou récupération de son id
            //dans une variable de session sql @id
            $sql = "CALL proc_insert_personne_pdo(?,?,NULL)";
            $stm = $connexion->prepare($sql);
            $stm->execute([$nom, $prenom]);

            //Insertion de l'utilisateur
            $sql = "INSERT INTO utilisateurs (email, mot_de_passe, personne_id)
                VALUES (?,?,@id)";
            $stm = $connexion->prepare($sql);
            $stm->execute([$email, sha1($mdp)]);

            //Redirection vers la page d'accueil
            $_SESSION["flash"] = "Vous êtes inscrit vous pouvez maintenant vous identifier";
            header("location:index.php?controller=accueil");

        }//Fin insertion des données
    } catch (PDOException $e) {
        $_SESSION["flash"] = "Impossible de traiter les données" . $e->getMessage();
    }//Fin try catch

}//Fin traitement du formulaire

//Affichage de la vue
renderView(
    "inscription",
    [
        "pageTitle" => "Inscription",
        "errors" => $errors
    ]
);