<?php

/**
 * Entité représentant une conversation définie par les champs
 * id, first_interlocutor_id, second_interlocutor_id
 */
class Conversation extends AbstractEntity
{
    private int $firstInterlocutorId;
    private int $secondInterlocutorId;

    /**
     * Setter pour l'id du 1er interlocuteur de la conversation. 
     * @param int $firstInterlocutorId
     */
    public function setFirstInterlocutorId(int $firstInterlocutorId): void
    {
        $this->firstInterlocutorId = $firstInterlocutorId;
    }

    /**
     * Getter pour l'id du 1er interlocuteur de la conversation.
     * @return int
     */
    public function getFirstInterlocutorId(): int
    {
        return $this->firstInterlocutorId;
    }

    /**
     * Setter pour l'id du 2ème interlocuteur de la conversation. 
     * @param int $secondInterlocutorId
     */
    public function setSecondInterlocutorId(int $secondInterlocutorId): void
    {
        $this->secondInterlocutorId = $secondInterlocutorId;
    }

    /**
     * Getter pour l'id du 2ème interlocuteur de la conversation.
     * @return int
     */
    public function getSecondInterlocutorId(): int
    {
        return $this->secondInterlocutorId;
    }
}
