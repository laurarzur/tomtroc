<?php
// Page d'accueil
?>
<section class="darker-bg-section">
    <div class="home-introduction-container container flex flex-row justify-center items-center">
        <div class="content-container flex flex-col">
            <div class="text-container flex flex-col">
                <h1>Rejoignez nos lecteurs passionnés</h1>
                <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la magie du partage de connaissances et d'histoires à travers les livres.</p>
            </div>
            <a href="#" class="btn btn-primary">Découvrir</a>
        </div>
        <div class="img-container flex flex-col items-end">
            <img src="../../img/hamza-nouasria-unsplash.jpg" alt="Vieil homme lisant devant une librairie remplie de livres" aria-hidden="true">
            <p class="tiny-grey-text">Hamza</p>
        </div>
    </div>
</section>
<section>
    <div class="books-introduction-container smaller-container flex flex-col items-center">
        <h2>Les derniers livres ajoutés</h2>
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
        <a href="#" class="btn btn-primary">Voir tous les livres</a>
    </div>
</section>
<section class="darker-bg-section">
    <div class="steps-introduction-container container flex flex-col items-center">
        <div class="steps-introduction-title-div flex flex-col items-center">
            <h2>Comment ça marche ?</h2>
            <p class="text-center">Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
        </div>
        <div class="steps-container flex flex-row">
            <article class="step-card">
                <p class="text-center">Inscrivez-vous gratuitement sur notre plateforme.</p>
            </article>
            <article class="step-card">
                <p class="text-center">Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
            </article>
            <article class="step-card">
                <p class="text-center">Parcourez les livres disponibles chez d'autres membres.</p>
            </article>
            <article class="step-card">
                <p class="text-center">Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
            </article>
        </div>
        <a href="#" class="btn btn-secondary">Voir tous les livres</a>
    </div>
</section>
<section class="bg-img-section">
</section>
<section class="darker-bg-section values-section">
    <div class="values-container container flex flex-col relative">
        <h2>Nos valeurs</h2>
        <p class="values-text">
            Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont
            ancrées dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous
            croyons en la puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes.
            <br><br>
            Notre association a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé.
            <br><br>
            Nous sommes passionnés par la création d'une plateforme conviviale qui permet aux lecteurs de se connecter,
            de partager leurs découvertes littéraires et d'échanger des livres qui attendent patiemment sur les étagères.
        </p>
        <p class="tiny-grey-text italic">L’équipe Tom Troc</p>
        <svg xmlns="http://www.w3.org/2000/svg" class="absolute heart-svg" width="122" height="104" viewBox="0 0 120 102" fill="none" aria-hidden="true">
            <path d="M1 96.2224V96.2224C2.29696 95.8216 6.2879 96.4842 7.64535 96.4785C34.2391 96.3656 77.2911 74.6923 96.4064 56.0062C109.127 40.7664 119.928 7.80529 85.8057 2.24352C65.0283 -1.1431 50.1873 26.7966 62.0601 33.1465C66.0177 35.2631 78.258 25.6112 65.0283 12.4034C51.7986 -0.804455 39.7279 0.126873 35.3463 2.24352C15.417 7.74679 2.27208 42.7137 71.8127 87.7558C96.4064 103.685 121 102.996 121 102.996" stroke="#00AC66" stroke-width="2" stroke-linecap="round" />
        </svg>
    </div>
</section>