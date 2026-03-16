<?php

/**
 * Classe qui gère les utilisateurs.
 */
class UserManager extends AbstractEntityManager
{

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
