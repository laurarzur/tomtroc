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

        Utils::redirect("home");
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

        Utils::redirect("home");
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
