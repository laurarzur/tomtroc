<?php

/**
 * Classe qui gère les messages.
 */
class MessageManager extends AbstractEntityManager
{

    /**
     * Envoi un message.
     * @param int $senderId 
     * @param int $recipientId 
     * @param string $content 
     * @param int $conversationId
     * @return void 
     */
    public function sendMessage(int $senderId, int $recipientId, string $content, int $conversationId): void
    {
        $sql = "INSERT INTO message (content, created_at, seen, sender_id, recipient_id, conversation_id) VALUES (:content, NOW(), 0, :sender_id, :recipient_id, :conversation_id)";
        $this->db->query($sql, [
            'content' => $content,
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'conversation_id' => $conversationId
        ]);
    }

    /**
     * Récupère le dernier message de chaque conversation d'un utilisateur. 
     * @param int $id 
     * @return Message|null
     */
    public function getLastMessageFromConversation(int $id): ?Message
    {

        $sql = "SELECT * FROM message WHERE conversation_id = :conversation_id ORDER BY created_at DESC LIMIT 1";
        $result = $this->db->query($sql, [
            'conversation_id' => $id
        ]);
        $message = $result->fetch();
        if ($message) {
            return new Message($message);
        }
        return null;
    }

    /**
     * Récupère tous les messages d'une conversation entre 2 utilisateurs.
     * @param int $id 
     * @return array : un tableau d'objets Message
     */
    public function getAllMessagesFromConversation(int $id): array
    {
        $sql = "SELECT * FROM message WHERE conversation_id = :conversation_id ORDER BY created_at ASC";
        $result = $this->db->query($sql, [
            'conversation_id' => $id
        ]);
        $messages = [];

        while ($message = $result->fetch()) {
            $messages[] = new Message($message);
        }

        return $messages;
    }

    /**
     * Récupère le nombre de messages non lus d'un utilisateur.
     * @param int $id
     * @return int 
     */
    public function getNumberOfUnseenMessagesByUser(int $id): int
    {
        $sql = "SELECT COUNT(id) AS count FROM message WHERE seen = 0 AND recipient_id  = :recipient_id";
        $result = $this->db->query($sql, [
            'recipient_id' => $id
        ]);
        $notificationsNumber = $result->fetch();

        return (int)$notificationsNumber['count'];
    }

    /**
     * Passe le(s) message(s) de l'interlocuteur en vus. 
     * @param int $userId : l'id de l'utilisateur connecté
     * @param int $interlocutorId
     * @return void
     */
    public function updateMessagesToSeen(int $userId, int $interlocutorId): void
    {
        $sql = "UPDATE message SET seen = 1 WHERE seen = 0 AND sender_id = :sender_id AND recipient_id = :recipient_id";
        $this->db->query($sql, [
            'sender_id' => $interlocutorId,
            'recipient_id' => $userId
        ]);
    }
}
