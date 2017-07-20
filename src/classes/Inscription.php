<?php
namespace m2i\web;

/**
 *
 * User: Administrateur
 * Date: 26/06/2017
 * Time: 09:49
 */

class Inscription
{
    /**
     * Les données de l'inscription
     * @var array
     */
    private $data = [];

    /**
     * Tableau des erreurs de validation des données et des règles métiers
     * @var array
     */
    private $errors = [];

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Inscription constructor.
     * @param array $data
     */
    public function __construct(array $data, \PDO $pdo)
    {
        $this->data = $this->SanitizeData($data);
        $this->pdo = $pdo;
    }

    /**
     * @param array $data
     * @return array
     */
    private function SanitizeData($data){
        //Règles de nettoyage des données
        $rules = [
            "nom" => FILTER_SANITIZE_STRING,
            "prenom" => FILTER_SANITIZE_STRING,
            "mdp" => FILTER_SANITIZE_STRING,
            "confirmation-mdp" => FILTER_SANITIZE_STRING,
            "email" => FILTER_VALIDATE_EMAIL,
            "submit" => FILTER_DEFAULT
        ];

        //Nettoyage des données
        $data = filter_var_array($data, $rules);

        //Retrourne le tableau nettoyé
        return $data;
    }

    /**
     * Validation de la saisie du formulaire
     */
    private function validateInput(){
        if (empty($this->data["nom"])) {
            $this->errors[] = "Vous devez saisir un nom";
        }
        if (empty($this->data["email"])) {
            $this->errors[] = "Vous devez saisir un email";
        }

        if (empty($this->data["mdp"])) {
            $this->errors[] = "Vous devez saisir un mot de passe";
        }
        if ($this->data["mdp"] != $this->data["confirmation-mdp"]) {
            $this->errors[] = "Le mot de passe et sa confirmation doivent être identiques";
        }

        return !$this->hasErrors();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function hasErrors():bool {
        return count($this->errors) > 0;
    }

    /**
     * @return bool
     */
    private function emailAlreadyExists(){
        $sql = "SELECT email FROM utilisateurs WHERE email=?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$this->data["email"]]);
        return count($stm->fetchAll(\PDO::FETCH_ASSOC)) >0;
    }

    /**
     * @return bool
     */
    private function personAlreadyRegistered(){
        $sql = "SELECT p.personne_id FROM personnes as p INNER JOIN utilisateurs as u
                ON p.personne_id=u.personne_id
                WHERE p.nom=? and p.prenom =?";
        $stm = $this->pdo->prepare($sql);
        $stm->execute([$this->data["nom"], $this->data["prenom"]]);
        return count($stm->fetchAll(\PDO::FETCH_ASSOC)) >0;
    }

    /**
     * Validation des règles métier
     */
    private function validateBusinessRules(){
        //Validation des règles métier uniquement si la saisie est valide
        if($this->validateInput()){
            if ($this->emailAlreadyExists()) {
                $this->errors[] = "Cette adresse email est déjà utilisée";
            }

            if ($this->personAlreadyRegistered()) {
                $this->errors[] = "Vous vous êtes déjà inscrit en tant qu'utilisateur";
            }
        }

        return !$this->hasErrors();
    }

    /**
     * Enregistrement de la personne et du compte utilisateur ds la base de données
     */
    private function persist(){
        if($this->validateBusinessRules()){

            $this->pdo->beginTransaction();

            $sql = "CALL proc_insert_personne_pdo(?,?,NULL)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$this->data["nom"], $this->data["prenom"]]);

            //Insertion de l'utilisateur
            $sql = "INSERT INTO utilisateurs (email, mot_de_passe, personne_id)
                VALUES (?,?,@id)";
            $stm = $this->pdo->prepare($sql);
            $stm->execute([$this->data["email"], sha1($this->data["mdp"])]);

            $this->pdo->commit();
        }
    }

    public function handleRequest(){
        $this->persist();
    }

    public function isFormSubmitted(){
        return isset($this->data["submit"]);
    }

}