<?php
// Page présentant les livres à l'échange
?>

<section class="books-section">
    <div class="books-introduction-container smaller-container flex flex-col">
        <div class="flex search-bar-container">
            <h1>Nos livres à l'échange</h1>
            <form action="index.php?action=books" role="search">
                <div class="search-bar flex flex-row-reverse items-center">
                    <input type="hidden" name="action" value="books">
                    <input class="search-input" type="search" name="title" placeholder="Rechercher un livre">
                    <button type="submit" aria-label="Rechercher">
                        <i class="fa-solid fa-magnifying-glass" style="color: #a6a6a6;"></i>
                    </button>
                </div>
            </form>
        </div>
        <?php if (count($books)) { ?>
            <div class="books-container">
                <?php foreach ($books as $book) { ?>
                    <a href="#">
                        <article class="book-card h-full">
                            <img src="img/books/<?= $book["book"]->getImg(); ?>" alt="Couverture du livre <?= $book["book"]->getTitle(); ?>" class="book-card-img">
                            <div class="book-card-content flex flex-col justify-between">
                                <div class="book-card-infos flex flex-col">
                                    <p class="one-line-clipped-text"><?= $book["book"]->getTitle(); ?></p>
                                    <p class="book-card-author"><?= $book["book"]->getAuthor(); ?></p>
                                </div>
                                <p class="book-card-owner">Vendu par : <?= $book["owner"]->getUsername(); ?></p>
                            </div>
                        </article>
                    </a>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p>Aucun livre disponible</p>
        <?php } ?>
    </div>
</section>