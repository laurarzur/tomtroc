<?php


class ConversationService
{
    private ConversationManager $conversationManager;
    private MessageManager $messageManager;
    private UserManager $userManager;

    public function __construct()
    {
        $this->conversationManager = new ConversationManager();
        $this->messageManager = new MessageManager();
        $this->userManager = new UserManager();
    }

    /**
     * Renvoie la liste des conversations d'un utilisateur avec le dernier message et son interlocuteur
     * @param int $userId 
     * @return array
     */
    public function getUserConversations(int $userId): array
    {
        $conversations = $this->conversationManager->getAllConversationsByUser($userId);
        $conversationsData = [];

        foreach ($conversations as $conversation) {
            $lastMessage = $this->messageManager->getLastMessageFromConversation($conversation->getId());
            $interlocutorId = ($lastMessage->getRecipientId() === $userId)
                ? $lastMessage->getSenderId()
                : $lastMessage->getRecipientId();

            $interlocutor = $this->userManager->getUserById($interlocutorId);
            $conversationsData[] = ['message' => $lastMessage, 'user' => $interlocutor];
        }

        usort($conversationsData, fn($a, $b) => $b['message']->getCreatedAt() <=> $a['message']->getCreatedAt());

        return $conversationsData;
    }

    /**
     * Récupère tous les messages d'une conversation entre 2 utilisateurs.
     * @return array : un tableau d'objets Message
     */
    public function getFullConversationByUsers(int $userId, int $interlocutorId): array
    {

        $conversation = $this->conversationManager->getConversationByUsers($userId, $interlocutorId);

        $fullConversation = [];

        if ($conversation) {
            $fullConversation = $this->messageManager->getAllMessagesFromConversation($conversation->getId());
        }
        return $fullConversation;
    }
}
