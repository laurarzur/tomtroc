<?php

/**
 * Classe utilitaire : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Utils.
 * Exemple : Utils::redirect('home'); 
 */
class Utils
{


    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur).
     * @param array $params : Facultatif, les paramètres de l'action sous la forme ['param1' => 'valeur1', 'param2' => 'valeur2']
     * @return void
     */
    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * Récupère une variable de la superglobale $_REQUEST.
     * Si cette variable n'est pas définie, on renvoie la valeur null (par défaut)
     * ou celle qui est passée en paramètre si elle existe.
     * @param string $variableName : le nom de la variable à récupérer.
     * @param mixed $defaultValue : la valeur par défaut si la variable n'est pas définie.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Vérifie si l'utilisateur est connecté. 
     * Si ce n'est pas le cas, il est redirigé vers le formulaire de connexion.
     * @return void
     */
    public static function checkIfUserIsLoggedIn(): void
    {
        if (!isset($_SESSION['user'])) {
            self::redirect('login-form');
        }
    }

    /**
     * Calcule le temps écoulé depuis un temps donné. 
     * @param Datetime $datetime : le temps à partir duquel on doit calculer 
     * @return string
     */
    public static function calculateTimeSinceDatetime(Datetime $datetime): string
    {
        $now = new DateTime();
        $timeSince = $now->diff($datetime);

        if ($timeSince->y > 0) {
            return $timeSince->y . " an" . ($timeSince->y > 1 ? "s" : "");
        }
        if ($timeSince->m > 0) {
            return $timeSince->m . " mois";
        }
        if ($timeSince->d > 0) {
            return $timeSince->d . " jour" . ($timeSince->d > 1 ? "s" : "");
        }
        if ($timeSince->h > 0) {
            return $timeSince->h . " heure" . ($timeSince->h > 1 ? "s" : "");
        }
        if ($timeSince->i > 0) {
            return $timeSince->i . " minute" . ($timeSince->i > 1 ? "s" : "");
        }
        return "quelques secondes";
    }
}
