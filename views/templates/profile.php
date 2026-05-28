<?php
// Page du profil utilisateur
?>

<section class="profile-section">
    <div class="profile-container container flex flex-col">
        <h1>Mon compte</h1>
        <div class="profile-infos-container">
            <div class="profile-infos-card flex flex-col items-center">
                <div class="profile-avatar-container flex flex-col items-center">
                    <img class="profile-avatar" src="img/users/<?= $user->getAvatar(); ?>" alt="Photo de profil de <?= $user->getUsername(); ?>">
                    <form action="index.php?action=edit-avatar" method="post" enctype="multipart/form-data" class="avatar-form flex flex-col">
                        <input type="file" name="avatar" id="avatar" accept="image/png, image/jpg, image/jpeg, image/webp" onchange="this.form.submit()">
                        <label for="avatar">modifier</label>
                    </form>
                    <?php if (!empty($_SESSION['img_form_errors'])) { ?>
                        <div class="alert-error">
                            <ul>
                                <?php foreach ($_SESSION['img_form_errors'] as $error) { ?>
                                    <li><i class="fa-solid fa-triangle-exclamation"></i><?= htmlspecialchars($error) ?></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php }
                    unset($_SESSION['img_form_errors']); ?>
                </div>
                <div class="profile-line"></div>
                <div class="profile-infos flex flex-col items-center">
                    <h2><?= $user->getUsername(); ?></h2>
                    <p>Membre depuis <?= Utils::calculateTimeSinceDatetime($user->getCreatedAt()); ?></p>
                    <div class="profile-library-infos flex flex-col items-center">
                        <p class="library">Bibliothèque</p>
                        <div class="library-content flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="14" viewBox="0 0 11 14" fill="none" role="img">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.46556 0.160154L7.2112 0.00251429C6.65202 -0.0365878 6.16701 0.385024 6.12791 0.944207L5.32192 12.4705C5.28281 13.0296 5.70442 13.5147 6.26361 13.5538L8.51796 13.7114C9.07715 13.7505 9.56215 13.3289 9.60125 12.7697L10.4072 1.24345C10.4464 0.684262 10.0247 0.199256 9.46556 0.160154ZM6.84113 0.99408C6.85269 0.828798 6.99605 0.70418 7.16133 0.715737L9.41568 0.873377C9.58096 0.884935 9.70558 1.02829 9.69403 1.19357L8.88803 12.7198C8.87647 12.8851 8.73312 13.0097 8.56783 12.9982L6.31348 12.8405C6.1482 12.829 6.02358 12.6856 6.03514 12.5203L6.84113 0.99408Z" fill="#292929" />
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3.27482 0.0648067H1.01496C0.454414 0.0648067 0 0.519224 0 1.07977V12.6342C0 13.1947 0.454416 13.6491 1.01496 13.6491H3.27482C3.83537 13.6491 4.28979 13.1947 4.28979 12.6342V1.07977C4.28979 0.519221 3.83537 0.0648067 3.27482 0.0648067ZM0.714965 1.07977C0.714965 0.914086 0.849279 0.779771 1.01496 0.779771H3.27482C3.44051 0.779771 3.57482 0.914086 3.57482 1.07977V12.6342C3.57482 12.7999 3.44051 12.9342 3.27482 12.9342H1.01496C0.849279 12.9342 0.714965 12.7999 0.714965 12.6342V1.07977Z" fill="#292929" />
                            </svg>
                            <p><?= count($books); ?> livres</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="btn btn-secondary">Ajouter un livre</a>
            </div>
            <div class="profile-infos-card profile-form-container flex flex-col">
                <p>Vos informations personnelles</p>
                <?php if (!empty($_SESSION['form_errors'])) { ?>
                    <div class="alert-error">
                        <ul>
                            <?php foreach ($_SESSION['form_errors'] as $error) { ?>
                                <li><i class="fa-solid fa-triangle-exclamation"></i><?= htmlspecialchars($error) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <form action="index.php?action=edit-profile" method="post" class="profile-form flex flex-col">
                    <div class="flex flex-col">
                        <label for="email">Adresse email</label>
                        <input type="email" name="email" id="email" value="<?= $user->getEmail(); ?>" required aria-required="true">
                    </div>
                    <div class="flex flex-col">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" value="........" required aria-required="true">
                    </div>
                    <div class="flex flex-col">
                        <label for="username">Pseudo</label>
                        <input type="text" name="username" id="username" value="<?= $user->getUsername(); ?>" required aria-required="true">
                    </div>
                    <div class="flex">
                        <input type="checkbox" name="public" id="public" <?= $user->getPublic() == 1 ? 'checked' : '' ?>>
                        <label for="public">Compte public</label>
                    </div>
                    <input type="submit" value="Enregistrer" class="btn btn-secondary">
                </form>
                <?php unset($_SESSION['form_errors']); ?>
            </div>
        </div>
        <?php
        if (count($books)) { ?>
            <table class=" books-table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Description</th>
                        <th>Disponibilité</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($books as $book) { ?>
                        <tr>
                            <td><img src="img/books/<?= $book->getImg(); ?>" alt="Couverture du livre <?= $book->getTitle(); ?>"></td>
                            <td><?= $book->getTitle(); ?></td>
                            <td><?= $book->getAuthor(); ?></td>
                            <td>
                                <p class="clipped-review"><?= $book->getReview(); ?></p>
                            </td>
                            <td><?= $book->getAvailable() == 1 ? '<p class="badge available-badge">disponible</p>' : '<p class="badge unavailable-badge">non dispo.</p>'; ?></td>
                            <td>
                                <a href="#">Éditer</a>
                                <a href="#">Supprimer</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</section>