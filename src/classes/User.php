<?php
namespace m2i\web;
/**
 *
 * User: Administrateur
 * Date: 26/06/2017
 * Time: 13:54
 */
class User
{
    private $email;
    private $password;
    private $userName;
    private $role;
    private $id;

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * Chargement des données de l'utilisateur depuis la base de données (hydratation)
     */
    public function loadUser(\PDO $pdo, $email, $password){
        $ok = false;
        if(!empty($email) && !empty($password)){
            $sql = "SELECT CONCAT_WS(' ',p.prenom,p.nom) as username, u.role_utilisateur, u.email, u.mot_de_passe, u.personne_id as id
                FROM utilisateurs as u INNER JOIN personnes as p ON p.personne_id=u.personne_id 
                WHERE u.email=? AND u.mot_de_passe=?";
            $stm = $pdo->prepare($sql);
            $stm->execute([$email, sha1($password)]);
            $rs = $stm->fetch(\PDO::FETCH_ASSOC);

            //hydratation de l'objet
            $this->userName = $rs["username"];
            $this->password = $rs["mot_de_passe"];
            $this->email = $rs["email"];
            $this->role = $rs["role_utilisateur"];
            $this->id = $rs["id"];
        }

        return $rs;
    }

    public function deconnectable()
    {
        return (isset($this->role) && $this->role != "GUEST");
    }

    /**
     * Méthode invoquée lors de la sérialisation d'un objet
     * retourne un tableau des attributs de l'objet qui doivent être sérialisés
     * @return array
     */
    function __sleep()
    {
        return ["userName", "role", "email", "id"];
    }

    function loadUserById()
    {
        $pdo = getPDO();
        $sql = "SELECT CONCAT_WS(' ',p.prenom,p.nom) as username, u.role_utilisateur, u.email, u.mot_de_passe, u.personne_id as id
                FROM utilisateurs as u INNER JOIN personnes as p ON p.personne_id=u.personne_id 
                WHERE u.personne_id=?";
        $stm = $pdo->prepare($sql);
        $stm->execute([$this->id]);
        $rs = $stm->fetch(\PDO::FETCH_ASSOC);

        //hydratation de l'objet
        $this->userName = $rs["username"];
        $this->password = $rs["mot_de_passe"];
        $this->email = $rs["email"];
        $this->role = $rs["role_utilisateur"];
        $this->id = $rs["id"];
    }

    function __wakeup()
    {
        if ($this->id != null) {
            $this->loadUserById();
        }
    }


}