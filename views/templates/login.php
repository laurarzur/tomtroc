<?php
// Page de connexion
?>
<section class="whole-page-section">
    <div class="one-sided-container larger-container right-container flex justify-between">
        <div class="login-signup-content flex flex-col">
            <h1>Connexion</h1>
            <?php if (!empty($_SESSION['form_errors'])) { ?>
                <div class="alert-error">
                    <ul>
                        <?php foreach ($_SESSION['form_errors'] as $error) { ?>
                            <li><i class="fa-solid fa-triangle-exclamation"></i><?= htmlspecialchars($error) ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
            <form action="index.php?action=login" method="post" class="signup-login-form flex flex-col">
                <div class="flex flex-col">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email" value="<?= !empty($_SESSION['old_inputs']) ? htmlspecialchars($_SESSION['old_inputs']['email']) : ''; ?>" required aria-required="true">
                </div>
                <div class="flex flex-col">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required aria-required="true">
                </div>
                <input type="submit" value="Se connecter" class="btn btn-primary">
            </form>
            <?php
            unset($_SESSION['form_errors']);
            unset($_SESSION['old_inputs']) ?>
            <div class="wrong-form-text flex flex-row">
                <p>Pas de compte ?</p>
                <a href="index.php?action=signup-form">Inscrivez-vous</a>
            </div>
        </div>
        <img src="../../img/marialaura-gionfriddo-unsplash.jpg" alt="Étagères remplies de livres" class="book-presentation-img">
    </div>
</section>