<?php

/**
 * Classe qui gère les livres.
 */
class BookManager extends AbstractEntityManager
{

    public const UPLOAD_DIR = "img/books/";

    /**
     * Récupère les 4 derniers livres ajoutés et disponibles à l'échange.
     * @return array : un tableau d'objets Book.
     */
    public function getLastAvailableBooks(): array
    {
        $sql = "SELECT * FROM book WHERE available = 1 ORDER BY id DESC LIMIT 4";
        $result = $this->db->query($sql);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }

    /**
     * Récupère tous les livres disponibles à l'échange.
     * @return array : un tableau d'objets Book.
     */
    public function getAllAvailableBooks(?string $title = ""): array
    {
        $sql = "SELECT * FROM book WHERE available = 1";

        if ($title) {
            $sql .= ' AND title LIKE "%' . $title . '%"';
        }

        $result = $this->db->query($sql);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }

    /**
     * Récupère un livre par son id.
     * @param int $id : l'id du livre.
     * @return Book|null : un objet Book ou null si le livre n'existe pas.
     */
    public function getBookById(int $id): ?Book
    {
        $sql = "SELECT * FROM book WHERE id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $book = $result->fetch();
        if ($book) {
            return new Book($book);
        }
        return null;
    }

    /**
     * Récupère tous les livres de l'utilisateur connecté.
     * @return array : un tableau d'objets Book.
     */
    public function getAllBooksByOwner(): ?array
    {
        $sql = "SELECT * FROM book WHERE owner_id = :id";
        $result = $this->db->query($sql, ['id' => $_SESSION['userId']]);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }

    /**
     * Récupère tous les livres disponibles d'un utilisateur. 
     * @param int $id : l'id de l'utilisateur
     * @return array : un tableau d'objets Book.
     */
    public function getAllAvailableBooksByOwner(int $id): array
    {
        $sql = "SELECT * FROM book WHERE available = 1 AND owner_id = :id";
        $result = $this->db->query($sql, ['id' => $id]);
        $books = [];

        while ($book = $result->fetch()) {
            $books[] = new Book($book);
        }
        return $books;
    }

    /**
     * Ajoute ou modifie un livre.
     * Si l'id du livre est -1, cela signifie que c'est un ajout.
     * @param Book $book : le livre à ajouter ou modifier.
     * @return void
     */
    public function addOrUpdateBook(Book $book): void
    {
        if ($book->getId() == -1) {
            $this->addBook($book);
        } else {
            $this->updateBook($book);
        }
    }

    /**
     * Ajoute un livre.
     * @param Book $book : le livre à ajouter.
     * @return void
     */
    public function addBook(Book $book): void
    {
        $sql = "INSERT INTO book (title, author, review, available, owner_id) VALUES (:title, :author, :review, :available, :owner_id)";
        $this->db->query($sql, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'review' => $book->getReview(),
            'available' => $book->getAvailable(),
            'owner_id' => $book->getOwnerId()
        ]);
    }

    /**
     * Modifie un livre.
     * @param Book $book : le livre à modifier.
     * @return void
     */
    public function updateBook(Book $book): void
    {
        $sql = "UPDATE book SET title = :title, author = :author, review = :review, available = :available, owner_id = :owner_id WHERE id = :id";
        $this->db->query($sql, [
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'review' => $book->getReview(),
            'available' => $book->getAvailable(),
            'owner_id' => $book->getOwnerId(),
            'id' => $book->getId()
        ]);
    }

    /**
     * Modifie l'image d'un livre.
     * @param int $id : l'id du livre
     * @param string $fileName : l'image à insérer en BDD
     * @param string $fileTmp : le chemin temporaire de l'image
     * @return void
     */
    public function updateBookImage(int $id, string $fileName, string $fileTmp): void
    {
        $oldImg = $this->getBookById($id)->getImg();

        $sql = "UPDATE book SET img = :img WHERE id = :id";
        $this->db->query($sql, [
            'img' => $fileName,
            'id' => $id
        ]);

        move_uploaded_file($fileTmp, self::UPLOAD_DIR . $fileName);

        $this->deleteBookImage($oldImg);
    }

    /**
     * Supprime l'ancienne image d'un livre. 
     * @param string $oldImg : l'image à supprimer 
     * @return void
     */
    public function deleteBookImage(string $oldImg): void
    {
        if ($oldImg !== "default-book.jpg") {
            $oldFilePath = self::UPLOAD_DIR . $oldImg;
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
    }

    /**
     * Supprime un livre.
     * @param int $id : l'id du livre à supprimer.
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $oldImg = $this->getBookById($id)->getImg();

        $sql = "DELETE FROM book WHERE id = :id";
        $this->db->query($sql, ['id' => $id]);

        $this->deleteBookImage($oldImg);
    }
}
