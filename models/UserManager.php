<?php

/**
 * Classe qui gère les utilisateurs.
 */
class UserManager extends AbstractEntityManager
{

    /**
     * Inscrit un utilisateur.
     * @param string $username
     * @param string $email
     * @param string $password
     * @return ?User : l'utilisateur inscrit
     */
    public function signup(string $username, string $email, string $password): ?User
    {

        $user = $this->getUserByEmail($email);

        if ($user) {
            return null;
        }

        $sql = "INSERT INTO user (username, email, pwd, created_at) VALUES (:username, :email, :pwd, NOW())";
        $this->db->query($sql, [
            'username' => $username,
            'email' => $email,
            'pwd' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        $newUser = $this->getUserByEmail($email);

        return $newUser;
    }

    /**
     * Récupère un utilisateur par son email.
     * @param string $email
     * @return ?User
     */
    public function getUserByEmail(string $email): ?User
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $result = $this->db->query($sql, ['email' => $email]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }

    /**
     * Récupère un utilisateur par son id.
     * @param int $id
     * @return ?User
     */
    public function getUserById(int $id): ?User
    {
        $sql = "SELECT * FROM user WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $user = $result->fetch();
        if ($user) {
            return new User($user);
        }
        return null;
    }
}
