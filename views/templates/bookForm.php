<?php
// Page de modification ou ajout d'un livre
?>
<section class="relative">
    <div class="relative container book-form-container flex flex-col">
        <a class="breadcrumb-link absolute" href="index.php?action=profile">← retour</a>
        <h1><?= $book->getId() == -1 ? "Ajouter un livre" : "Modifier les informations" ?></h1>
        <div class="book-form-block flex <?= $book->getId() == -1 ? 'justify-center' : 'justify-between' ?>">
            <?php
            if ($book->getId() !== -1) { ?>
                <div class="book-img-form-container flex flex-col">
                    <p class="label">Photo</p>
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
                    <img src="img/books/<?= $book->getId() == -1 ? 'default-book.jpg' : $book->getImg() ?>" alt="Couverture du livre" class="book-img">
                    <form action="index.php?action=edit-book-img&id=<?= $book->getId(); ?>" method="post" enctype="multipart/form-data" class="book-img-form flex justify-end">
                        <input type="file" name="img" id="img" accept="image/png, image/jpg, image/jpeg, image/webp" onchange="this.form.submit()">
                        <label for="img">Modifier la photo</label>
                    </form>
                </div>
            <?php } ?>
            <form action="index.php?action=edit-book&id=<?= $book->getId(); ?>" method="post" class="book-form flex flex-col">
                <?php if (!empty($_SESSION['form_errors'])) { ?>
                    <div class="alert-error">
                        <ul>
                            <?php foreach ($_SESSION['form_errors'] as $error) { ?>
                                <li><i class="fa-solid fa-triangle-exclamation"></i><?= htmlspecialchars($error) ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
                <div class="flex flex-col">
                    <label for="title">Titre</label>
                    <input type="text" name="title" id="title" value="<?= !empty($_SESSION['old_inputs']) ? htmlspecialchars($_SESSION['old_inputs']['title']) : $book->getTitle(); ?>" required aria-required="true">
                </div>
                <div class="flex flex-col">
                    <label for="author">Auteur</label>
                    <input type="text" name="author" id="author" value="<?= !empty($_SESSION['old_inputs']) ? htmlspecialchars($_SESSION['old_inputs']['author']) : $book->getAuthor(); ?>" required aria-required="true">
                </div>
                <div class="flex flex-col">
                    <label for="review">Commentaire</label>
                    <textarea name="review" id="review" rows="10" required aria-required="true"><?= !empty($_SESSION['old_inputs']) ? htmlspecialchars($_SESSION['old_inputs']['review']) : $book->getReview(); ?></textarea>
                </div>
                <div class="flex flex-col">
                    <label for="available">Disponibilité</label>
                    <select name="available" id="available">
                        <option value="1" <?= $book->getAvailable() === 1 ? 'selected' : ''; ?>>disponible</option>
                        <option value="0" <?= $book->getAvailable() === 0 ? 'selected' : ''; ?>>indisponible</option>
                    </select>
                </div>
                <input type="submit" value="Valider" class="btn btn-primary">
            </form>
            <?php
            unset($_SESSION['form_errors']);
            unset($_SESSION['old_inputs']) ?>
        </div>
    </div>
</section>