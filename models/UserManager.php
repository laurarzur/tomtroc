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

    /**
     * Modifie un utilisateur.
     * @param User $user : l'utilisateur à modifier.
     * @return void
     */
    public function updateUser(User $user): void
    {
        $sql = "UPDATE user SET username = :username, email = :email, pwd = :pwd, public = :public WHERE id = :id";
        $this->db->query($sql, [
            'username' => $user->getUsername(),
            'email' => $user->getEmail(),
            'pwd' => $user->getNewPwd() !== "" ? $user->getNewPwd() : $user->getPwd(),
            'public' => $user->getPublic(),
            'id' => $user->getId()
        ]);
    }

    /**
     * Modifie l'image de profil d'un utilisateur.
     * @param string $fileName : l'image à insérer en BDD
     * @param string $fileTmp : le chemin temporaire de l'image
     * @return void
     */
    public function updateAvatar(string $fileName, string $fileTmp): void
    {
        $sql = "UPDATE user SET avatar = :avatar WHERE id = :id";
        $this->db->query($sql, [
            'avatar' => $fileName,
            'id' => $_SESSION['userId']
        ]);

        $uploadDir = "img/users/";
        move_uploaded_file($fileTmp, $uploadDir . $fileName);

        $oldAvatar = $_SESSION['user']->getAvatar();

        if ($oldAvatar !== "default-avatar.jpg") {
            $oldFilePath = $uploadDir . $oldAvatar;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }

        $_SESSION['user']->setAvatar($fileName);
    }
}
