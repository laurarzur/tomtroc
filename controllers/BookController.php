<?php

class BookController
{

    /**
     * Affiche tous les livres disponibles à l'échange. 
     * @return void
     */
    public function showAllAvailableBooks() //: void
    {
        $title = Utils::request("title", "");

        $bookManager = new BookManager();
        $books = $bookManager->getAllAvailableBooks(htmlspecialchars($title));

        $userManager = new UserManager();

        $booksData = [];

        foreach ($books as $book) {
            $bookOwner = $userManager->getUserById($book->getOwnerId());
            $bookData = ["book" => $book, "owner" => $bookOwner];
            $booksData[] = $bookData;
        }

        $view = new View("Nos livres à l'échange");
        $view->render("books", ['books' => $booksData]);
    }
}
