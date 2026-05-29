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

    /**
     * Affiche le formulaire de modification d'un livre.
     * @return void
     */
    public function showBookForm(): void
    {
        Utils::checkIfUserIsLoggedIn();
        $id = Utils::request("id", -1);

        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Impossible d'accéder au formulaire.</p><a href='index.php?action=profile'>Retour au compte</a>");
        }

        $bookManager = new BookManager();
        $book = $bookManager->getBookById($id);

        if (!$book) {
            $book = new Book([
                "id" => $id,
                "title" => "",
                "author" => "",
                "review" => "",
                "available" => 1
            ]);
        } elseif ($book->getOwnerId() !== $_SESSION['userId']) {
            throw new Exception("<p>Vous ne pouvez pas modifier ce livre.</p><a href='index.php?action=profile'>Retour au compte</a>");
        }

        $view = new View("Edition du livre");
        $view->render("bookForm", ["book" => $book]);
    }

    /**
     * Modifie les informations d'un livre. 
     * @return void
     */
    public function editBook(): void
    {
        Utils::checkIfUserIsLoggedIn();

        $id = Utils::request("id", -1);
        $title = Utils::request("title");
        $author = Utils::request("author");
        $review = Utils::request("review");
        $available = Utils::request("available");

        $errors = [];

        if ($title === "" || $author === "" || $review === "") {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if (!empty($errors)) {
            $_SESSION['form_errors'] = $errors;
            $_SESSION['old_inputs'] = $_POST;
            Utils::redirect("book-form", ["id" => $id]);
            return;
        }

        $book = new Book([
            "id" => $id,
            "title" => htmlspecialchars($title),
            "author" => htmlspecialchars($author),
            "review" => htmlspecialchars($review),
            "available" => (int)$available,
            "owner_id" => $_SESSION['userId']
        ]);

        $bookManager = new BookManager();
        $bookManager->addOrUpdateBook($book);

        Utils::redirect("profile");
    }

    /**
     * Modifie l'image d'un livre. 
     * @return void
     */
    public function editBookImage(): void
    {

        Utils::checkIfUserIsLoggedIn();

        $bookId = Utils::request("id", -1);

        if ($bookId === -1 || !filter_var($bookId, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Vous ne pouvez pas modifier cette image.</p><a href='index.php?action=profile'>Retour au compte</a>");
        }

        $fileName = $_FILES['img']['name'];
        $fileTmp = $_FILES['img']['tmp_name'];
        $fileSize = $_FILES['img']['size'];

        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
        $maxSize = 2 * 1024 * 1024;

        if (!in_array($fileExtension, $allowedExtensions)) {
            $errors[] = "Le format de l'image n'est pas valide (png, jpg, jpeg ou webp uniquement).";
        }

        if ($fileSize > $maxSize) {
            $errors[] = "L'image est trop volumineuse. Maximum autorisé : 2 Mo.";
        }

        if (!empty($errors)) {
            $_SESSION['img_form_errors'] = $errors;
            Utils::redirect("book-form", ["id" => $bookId]);
            return;
        }

        // Donne un nom aléatoire à l'image pour éviter les conflits de noms de fichiers
        $newFileName = uniqid('book_', true) . '.' . $fileExtension;


        $bookManager = new BookManager();
        $bookManager->updateBookImage($bookId, $newFileName, $fileTmp);

        Utils::redirect("profile");
    }

    public function deleteBook(): void
    {
        $id = Utils::request("id", -1);

        if ($id === -1 || !filter_var($id, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Le livre est introuvable.</p><a href='index.php?action=profile'>Retour au compte</a>");
        }

        $bookManager = new BookManager();
        $bookManager->deleteBook($id);

        Utils::redirect("profile");
    }
}
