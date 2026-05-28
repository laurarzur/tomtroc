<?php

class UserController
{
    /**
     * Affiche la page d'inscription.
     * @return void
     */
    public function showSignup(): void
    {
        $view = new View("Inscription");
        $view->render("signup");
    }

    /**
     * Inscrit un utilisateur puis le connecte
     * @return void
     */
    public function signup(): void
    {
        $username = Utils::request("username");
        $email = Utils::request("email");
        $password = Utils::request("password");

        $errors = [];

        if (empty($email) || empty($password) || empty($username)) {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;
            Utils::redirect("signup-form");
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->signup(htmlspecialchars($username), $email, $password);

        if (!$user) {
            throw new Exception("<p>Vous avez déjà un compte.</p><a href='index.php?action=login-form'>Se connecter</a>");
        }

        $_SESSION['user'] = $user;
        $_SESSION['userId'] = $user->getId();

        Utils::redirect("profile");
    }

    /**
     * Affiche la page de connexion.
     * @return void
     */
    public function showLogin(): void
    {
        $view = new View("Connexion");
        $view->render("login");
    }

    /**
     * Connecte un utilisateur 
     * @return void
     */
    public function login(): void
    {

        $email = Utils::request("email");
        $password = Utils::request("password");

        $errors = [];

        if (empty($email) || empty($password)) {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;
            Utils::redirect("login-form");
            return;
        }

        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->getPwd())) {
            $errors[] = "Les identifiants sont incorrects.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;
            Utils::redirect("login-form");
            return;
        }

        $_SESSION['user'] = $user;
        $_SESSION['userId'] = $user->getId();

        Utils::redirect("profile");
    }

    /**
     * Affiche le profil de l'utilisateur connecté
     * @return void
     */
    public function showProfile(): void
    {
        Utils::checkIfUserIsLoggedIn();

        $bookManager = new BookManager();
        $books = $bookManager->getAllBooksByOwner();

        $userManager = new UserManager();
        $user = $userManager->getUserById($_SESSION['userId']);

        $view = new View("Mon compte");
        $view->render("profile", ['user' => $user, 'books' => $books]);
    }

    /**
     * Modifie les informations de l'utilisateur 
     * @return void
     */
    public function editProfile(): void
    {
        Utils::checkIfUserIsLoggedIn();

        $email = Utils::request("email");
        $password = Utils::request("password");
        $username = Utils::request("username");
        $public = Utils::request("public") === "on" ? 1 : 0;

        $errors = [];

        if (empty($email) || empty($password) || empty($username)) {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "L'adresse email n'est pas valide.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            Utils::redirect("profile");
            return;
        }

        $user = $_SESSION['user'];

        if ($user->getEmail() !== $email) {
            $user->setEmail($email);
        }

        if ($password !== "........" && !password_verify($password, $user->getPwd())) {
            $user->setNewPwd(password_hash($password, PASSWORD_DEFAULT));
        }

        if ($user->getUsername() !== $username) {
            $user->setUsername(htmlspecialchars($username));
        }

        if ($user->getPublic() !== $public) {
            $user->setPublic($public);
        }

        $userManager = new UserManager();
        $userManager->updateUser($user);

        $_SESSION['user'] = $user;

        Utils::redirect("profile");
    }

    /**
     * Modifie la photo de profil de l'utilisateur 
     * @return void
     */
    public function editAvatar(): void
    {

        Utils::checkIfUserIsLoggedIn();

        $fileName = $_FILES['avatar']['name'];
        $fileTmp = $_FILES['avatar']['tmp_name'];
        $fileSize = $_FILES['avatar']['size'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
        $maxSize = 2 * 1024 * 1024;

        $errors = [];

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Le format de l'image n'est pas valide (png, jpg, jpeg ou webp uniquement).";
        }

        if ($fileSize > $maxSize) {
            $errors[] = "L'image est trop volumineuse. Maximum autorisé : 2 Mo.";
        }

        if (!empty($errors)) {
            $_SESSION['img_form_errors'] = $errors;
            Utils::redirect("profile");
            return;
        }

        // Donne un nom aléatoire à l'image pour éviter les conflits de noms de fichiers
        $newFileName = uniqid('avatar_', true) . '.' . $fileExtension;


        $userManager = new UserManager();
        $userManager->updateAvatar($newFileName, $fileTmp);

        Utils::redirect("profile");
    }

    /**
     * Affiche le profil d'un autre utilisateur 
     * @return void
     */
    public function showUserProfile(): void
    {
        $userId = Utils::request("id", -1);

        if (!filter_var($userId, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Cet utilisateur n'est pas disponible.</p><a href='index.php?action=books'>Voir les livres disponibles</a>");
        }

        if (isset($_SESSION['userId']) && $userId == $_SESSION['userId']) {
            Utils::redirect('profile');
        }

        $userManager = new UserManager();
        $user = $userManager->getUserById($userId);

        if (!$user || $user->getPublic() === 0) {
            throw new Exception('<p>Vous ne pouvez pas accéder à ce compte.</p><a href="index.php?action=books">Voir les livres disponibles</a>');
        }

        $bookManager = new BookManager();
        $books = $bookManager->getAllAvailableBooksByOwner($user->getId());

        $view = new View("Compte public");
        $view->render("userProfile", ['user' => $user, 'books' => $books]);
    }

    /**
     * Déconnecte un utilisateur 
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
        unset($_SESSION['userId']);
        Utils::redirect("home");
    }
}
