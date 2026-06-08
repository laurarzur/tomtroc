<?php

/**
 * Classe qui gère les conversations.
 */
class ConversationManager extends AbstractEntityManager
{

    /**
     * Crée une conversation.
     * @param int $senderId : le 1er interlocuteur.
     * @param int $recipientId : le 2ème interlocuteur.
     * @return void
     */
    public function createConversation(int $senderId, int $recipientId): void
    {
        $sql = "INSERT INTO conversation (first_interlocutor_id, second_interlocutor_id) VALUES (:first_interlocutor_id, :second_interlocutor_id)";
        $this->db->query($sql, [
            'first_interlocutor_id' => $senderId,
            'second_interlocutor_id' => $recipientId
        ]);
    }

    /**
     * Récupère une conversation par ses interlocuteurs.
     * @param int $senderId 
     * @param int $recipientId
     * @return Conversation|null
     */
    public function getConversationByUsers(int $senderId, int $recipientId): ?Conversation
    {
        $sql = "SELECT * FROM conversation WHERE (first_interlocutor_id = :sender_id AND second_interlocutor_id = :recipient_id) OR (first_interlocutor_id = :recipient_id AND second_interlocutor_id = :sender_id)";
        $result = $this->db->query($sql, [
            'sender_id' => $senderId,
            'recipient_id' => $recipientId
        ]);
        $conversation = $result->fetch();
        if ($conversation) {
            return new Conversation($conversation);
        }
        return null;
    }

    /**
     * Récupère toutes les conversations d'un utilisateur 
     * @param int $id
     */
    public function getAllConversationsByUser(int $id): array
    {
        $sql = "SELECT * FROM conversation WHERE first_interlocutor_id = :user_id OR second_interlocutor_id = :user_id  ORDER BY id DESC";
        $result = $this->db->query($sql, [
            'user_id' => $id
        ]);
        $conversations = [];

        while ($conversation = $result->fetch()) {
            $conversations[] = new Conversation($conversation);
        }

        return $conversations;
    }
}
