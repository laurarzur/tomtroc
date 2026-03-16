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
}
