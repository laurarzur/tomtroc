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


    /**
     * Affiche le détail d'un livre.
     * @return void
     */
    public function showBook(): void
    {
        $id = Utils::request("id", -1);

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Ce livre n'est pas disponible.</p><a href='index.php?action=books'>Voir les livres disponibles</a>");
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            throw new Exception("<p>Ce livre n'est pas disponible.</p><a href='index.php?action=books'>Voir les livres disponibles</a>");
        }

        $userManager = new UserManager();

        $bookOwner = $userManager->getUserById($book->getOwnerId());
        $bookData = ["book" => $book, "owner" => $bookOwner];


        $view = new View($book->getTitle());
        $view->render("singleBook", ['book' => $bookData]);
    }
}
