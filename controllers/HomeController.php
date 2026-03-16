<?php

class HomeController
{
    /**
     * Affiche la page d'accueil.
     * @return void
     */
    public function showHome(): void
    {
        $bookManager = new BookManager();
        $books = $bookManager->getLastAvailableBooks();

        $userManager = new UserManager();

        $booksData = [];

        foreach ($books as $book) {
            $bookOwner = $userManager->getUserById($book->getOwnerId());
            $bookData = ["book" => $book, "owner" => $bookOwner];
            $booksData[] = $bookData;
        }

        $view = new View("Accueil");
        $view->render("home", ['books' => $booksData]);
    }
}
