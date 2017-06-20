<?php
$connexion = getPDO();

//Récupération du paramètre id
$id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT);
//Si id n'est pas null alors requête pr récupérer le libellé de la matière
$matiere = "";
$pageTitle = "Nouvelle matière";
if($id!=null){
    $sql = "SELECT matiere FROM matieres WHERE matiere_id=?";
    $stm = $connexion->prepare($sql);
    $stm->execute([$id]);
    $rs = $stm->fetch(PDO::FETCH_ASSOC);
    $matiere = $rs['matiere'];
    $pageTitle = "Modification d'une matière";
}

//Traitement du formulaire
$isSubmitted = filter_has_var(INPUT_POST,'submit');
if($isSubmitted){
    //Récupération des données
    $matiere = filter_input(INPUT_POST,'matiere',FILTER_SANITIZE_STRING);
    $id = filter_input(INPUT_POST,'id',FILTER_VALIDATE_INT);

    //Validation des données saisies
    $valid = !(empty($matiere));

    //Valider que l'insertion ou la màj ne génère pas de doublon
    $sql = "SELECT matiere FROM matieres WHERE matiere=:matiere";
    $stm = $connexion->prepare($sql);
    $stm->execute(['matiere'=>$matiere]);
    $nbMatieres = count($stm->fetchAll(PDO::FETCH_ASSOC));
    $valid = $valid & ($nbMatieres==0);

    //Test de la validité du token
    $token = filter_input(INPUT_POST,'token',FILTER_DEFAULT);
    $valid = $valid & ($token == $_SESSION['token']);

    //En fonction de la valeur de $id on fait un insert ou un update
    try{
        if ($valid){
            //Paramètre commun aux deux requêtes
            $param = [];
            $param["matiere"] = $matiere;
            //Définition de la requête à éxécuter et ajout du paramètre id ds le cas d'une màj
            if($id==null){
                $sql = "INSERT INTO matieres (matiere) VALUES (:matiere)";
                $_SESSION['flash'] = "Votre nouvelle matière est enregistrée dans la base";
            } else {
                $sql = "UPDATE matieres SET matiere=:matiere WHERE matiere_id=:id";
                $param["id"] = $id;
                $_SESSION['flash'] = "Votre modification est enregistrée dans la base";
            }
            //Préparation et exécution de la requête
            $stm = $connexion->prepare($sql);
            $stm->execute($param);
            //redirection vers la liste des matières
            header("location:index.php?controller=matieres");
        } else $_SESSION['flash'] = "Votre saisie est incorrecte";
        
    } catch(PDOException $e){
        $_SESSION['flash'] = "Impossible d'exécuter la requête";
    }
}

//Génération d'un token de protection contre les attaques CSRF (Cross Site Request Forgery)
$token = uniqid();
$_SESSION['token'] = $token;

//Affichage de la vue
renderView(
    'matiere-form',
    [
        'pageTitle' => $pageTitle,
        'matiere' => $matiere,
        'id' => $id,
        'token' => $token
    ]
);