<?php
// Page de présentation d'un livre
?>
<section class="whole-page-section">
    <div class="one-sided-container larger-container left-container flex">
        <div class="book-presentation-img-container">
            <img src="img/books/<?= $book["book"]->getImg(); ?>" alt="Couverture du livre <?= $book["book"]->getTitle(); ?>" class="book-presentation-img">
        </div>
        <div class="book-details flex flex-col">
            <div class="book-basic-infos flex flex-col">
                <h1><?= $book["book"]->getTitle() ?></h1>
                <p>Par <?= $book["book"]->getAuthor() ?></p>
            </div>
            <div class="separator"></div>
            <div class="book-description-container flex flex-col">
                <p class="column-title">Description</p>
                <p class="book-description"><?= $book["book"]->getReview() ?></p>
            </div>
            <div class="book-owner-container flex flex-col">
                <p class="column-title">Propriétaire</p>
                <a class="book-owner flex flex-row items-center w-fit-content relative" <?php if ($book["owner"]->getPublic() == 1) { ?> href="<?= isset($_SESSION['userId']) && $book["owner"]->getId() == $_SESSION['userId'] ? 'index.php?action=profile' : 'index.php?action=user-profile&id=' . $book["owner"]->getId(); ?>" <?php } else { ?> title="Ce compte est privé" <?php } ?>>
                    <div class="book-owner-img-overlay"></div>
                    <img src="img/users/<?= $book["owner"]->getAvatar(); ?>" alt="Photo de profil de <?= $book["owner"]->getUsername(); ?>" class="book-owner-img">
                    <p class="book-owner-username"><?= $book["owner"]->getUsername(); ?></p>
                </a>
            </div>
            <a href="#" class="btn btn-primary">Envoyer un message</a>
        </div>
    </div>
</section>