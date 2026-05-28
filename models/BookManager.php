<?php

/**
 * Classe qui gère les livres.
 */
class BookManager extends AbstractEntityManager
{

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
}
