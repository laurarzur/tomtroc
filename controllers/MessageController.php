<?php

class MessageController
{

    /**
     * Affiche toutes les conversations d'un utilisateur. 
     * @return void
     */
    public function showMessagingPage(): void
    {
        Utils::checkIfUserIsLoggedIn();

        $id = $_SESSION['userId'];

        $conversationService = new ConversationService();
        $conversationsData = $conversationService->getUserConversations($id);

        $interlocutorId = Utils::request("userid", -1);

        if (!filter_var($interlocutorId, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Impossible d'accéder aux messages.</p><a href='index.php'>Retour à la page d'accueil</a>");
        }

        if ($interlocutorId == $id) {
            throw new Exception("<p>Vous ne pouvez pas vous envoyer de message.</p><a href='index.php?action=messages'>Voir la messagerie</a>");
        }


        if ($interlocutorId === -1 && !empty($conversationsData)) {
            $interlocutorId = $conversationsData[0]["user"]->getId();
        }

        $fullConversation = [];
        $interlocutor = new User();

        if ($interlocutorId !== -1) {
            $interlocutor = $this->getInterlocutorById($interlocutorId);
            $fullConversation = $conversationService->getFullConversationByUsers($id, $interlocutorId);
            $this->updateMessagesToSeen($interlocutorId);
        }


        $view = new View("Messagerie");
        $view->render("messages", [
            'conversations' => $conversationsData,
            'fullConversation' => $fullConversation,
            'interlocutor' => $interlocutor,
            'hasInterlocutor' => $interlocutorId !== -1,
            'hasConversation' => !empty($fullConversation)
        ]);
    }


    /**
     * Récupère les informations de l'interlocuteur d'une conversation.
     * @return User
     */
    private function getInterlocutorById(int $id): User
    {
        $userManager = new UserManager();
        $user = $userManager->getUserById($id);
        return $user;
    }


    /**
     * Envoie un message à un utilisateur
     * @return void
     */
    public function sendMessage(): void
    {
        Utils::checkIfUserIsLoggedIn();

        $interlocutorId = Utils::request("userid");

        if (!filter_var($interlocutorId, FILTER_VALIDATE_INT)) {
            throw new Exception("<p>Vous ne pouvez pas envoyer de message à cet utilisateur.</p><a href='index.php?action=messages'>Retour à la messagerie</a>");
        }

        $message = Utils::request("message");

        if (empty($message)) {
            Utils::redirect("messages", ['userid' => $interlocutorId]);
        }

        $conversationManager = new ConversationManager();
        $conversation = $conversationManager->getConversationByUsers($_SESSION['userId'], $interlocutorId);

        if (!$conversation) {
            $conversationManager->createConversation($_SESSION['userId'], $interlocutorId);
            $conversation = $conversationManager->getConversationByUsers($_SESSION['userId'], $interlocutorId);
        }

        $messageManager = new MessageManager();
        $messageManager->sendMessage($_SESSION['userId'], $interlocutorId, $message, $conversation->getId());

        Utils::redirect("messages", ['userid' => $interlocutorId]);
    }

    /**
     * Passe le(s) message(s) de l'interlocuteur en vus. 
     * @param int $interlocutorId
     * @return void
     */
    public function updateMessagesToSeen(int $interlocutorId): void
    {
        $id = $_SESSION['userId'];

        $messageManager = new MessageManager();
        $messageManager->updateMessagesToSeen($id, $interlocutorId);
    }
}
