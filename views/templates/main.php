<?php

/**
 * Ce fichier est le template principal qui "contient" ce qui aura été généré par les autres vues.  
 * 
 * Les variables qui doivent impérativement être définie sont : 
 *      $title string : le titre de la page.
 *      $content string : le contenu de la page. 
 */

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header class="header">
        <nav class="nav container flex flex-row items-center" aria-label="Navigation principale">
            <a href="index.php?action=home">
                <img src="../../img/logo.png" alt="logo Tomtroc - Page d'accueil" class="logo">
            </a>
            <div class="flex flex-row items-center justify-between w-full">
                <div class="nav-div flex flex-row">
                    <a href="index.php?action=home">Accueil</a>
                    <a href="index.php?action=books">Nos livres à l'échange</a>
                </div>
                <div class="nav-div flex flex-row">
                    <?php
                    // On affiche 'Inscription' et 'Connexion' si l'utilisateur n'est pas connecté
                    if (!isset($_SESSION['user'])) { ?>
                        <a href="index.php?action=signup-form">Inscription</a>
                        <a href="#">Connexion</a>
                    <?php
                        // Sinon, on lui donne accès à son compte et sa messagerie
                    } else { ?>
                        <a href="#"><i class="fa-regular fa-comment fa-flip-horizontal" style="color: #292929;"></i>Messagerie<span class="notifications">0</span></a>
                        <a href="#"><i class="fa-regular fa-user" style="color: #292929;"></i>Mon compte</a>
                        <a href="#">Déconnexion</a>
                    <?php } ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <?= $content; /* Ici est affiché le contenu réel de la page. */ ?>
    </main>

    <footer class="footer">
        <nav class="footer-nav flex flex-row items-center w-fit-content" aria-label="Navigation secondaire">
            <a href="#">Politique de confidentialité</a>
            <a href="#">Mentions légales</a>
            <p>Tom Troc©</p>
            <img src="../../img/logo-min.png" alt="logo Tomtroc" class="mini-logo" aria-hidden="true">
        </nav>
    </footer>

</body>

</html>