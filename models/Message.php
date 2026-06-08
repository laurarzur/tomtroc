<?php

/**
 * Entité représentant un message défini par les champs
 * id, content, created_at, seen, sender_id, recipient_id, conversation_id
 */
class Message extends AbstractEntity
{
    private string $content;
    private DateTime $createdAt;
    private int $seen = 0;
    private int $sender_id;
    private int $recipient_id;
    private int $conversation_id;

    /**
     * Setter pour le contenu.
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Getter pour le contenu.
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter pour la date de création. Si la date est une string, on la convertit en DateTime.
     * @param string|DateTime $createdAt
     * @param string $format : le format pour la convertion de la date si elle est une string.
     * Par défaut, c'est le format de date mysql qui est utilisé. 
     */
    public function setCreatedAt(string|DateTime $createdAt, string $format = 'Y-m-d H:i:s'): void
    {
        if (is_string($createdAt)) {
            $createdAt = DateTime::createFromFormat($format, $createdAt);
        }
        $this->createdAt = $createdAt;
    }

    /**
     * Getter pour la date de création.
     * Grâce au setter, on a la garantie de récupérer un objet DateTime.
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Setter pour le "vu". 
     * @param int $seen
     */
    public function setSeen(int $seen): void
    {
        $this->seen = $seen;
    }

    /**
     * Getter pour le "vu". 
     * @return int
     */
    public function getSeen(): int
    {
        return $this->seen;
    }

    /**
     * Setter pour l'id de l'expéditeur. 
     * @param int $sender_id
     */
    public function setSenderId(int $sender_id): void
    {
        $this->sender_id = $sender_id;
    }

    /**
     * Getter pour l'id de l'expéditeur. 
     * @return int
     */
    public function getSenderId(): int
    {
        return $this->sender_id;
    }

    /**
     * Setter pour l'id du destinataire. 
     * @param int $recipient_id
     */
    public function setRecipientId(int $recipient_id): void
    {
        $this->recipient_id = $recipient_id;
    }

    /**
     * Getter pour l'id du destinataire. 
     * @return int
     */
    public function getRecipientId(): int
    {
        return $this->recipient_id;
    }

    /**
     * Setter pour l'id de la conversation. 
     * @param int $conversation_id
     */
    public function setConversationId(int $conversation_id): void
    {
        $this->conversation_id = $conversation_id;
    }

    /**
     * Getter pour l'id de la conversation. 
     * @return int
     */
    public function getConversationId(): int
    {
        return $this->conversation_id;
    }
}
