<?php
// Page de messagerie
?>
<section class="messages-section darker-bg-section whole-page-section">
    <div class="container flex">
        <aside class="h-full" aria-label="Fil des conversations">
            <h1>Messagerie</h1>
            <?php
            foreach ($conversations as $conversation) { ?>
                <a href="index.php?action=messages&userid=<?= $conversation["user"]->getId(); ?>">
                    <div class="conversation-preview flex flex-row items-center <?= $conversation["user"]->getId() === $interlocutor->getId() ? 'current-conversation' : ''; ?>">
                        <div class="w-fit-content h-fit-content">
                            <img class="conversation-interlocutor-avatar" src="img/users/<?= $conversation["user"]->getAvatar(); ?>" alt="Photo de profil de <?= $conversation["user"]->getUsername(); ?>">
                        </div>
                        <div class="conversation-preview-infos flex flex-col w-full">
                            <div class="flex flex-row justify-between">
                                <p class="conversation-interlocutor-username"><?= $conversation["user"]->getUsername(); ?></p>
                                <p class="conversation-message-time"><?= Utils::formatDatetime($conversation["message"]->getCreatedAt()); ?></p>
                            </div>
                            <p class="conversation-message one-line-clipped-text"><?= $conversation["message"]->getContent(); ?></p>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </aside>
        <div class="conversation-container flex flex-col justify-center">
            <?php
            if ($hasInterlocutor) { ?>
                <div class="conversation-interlocutor flex flex-row items-center">
                    <img src="img/users/<?= $interlocutor->getAvatar(); ?>" alt="Photo de profil de <?= $interlocutor->getUsername(); ?>" class="conversation-interlocutor-avatar">
                    <p class="conversation-interlocutor-username"><?= $interlocutor->getUsername(); ?></p>
                </div>
                <div class="overflow-block flex flex-col-reverse">
                    <div class="conversation-block flex flex-col justify-end">
                        <?php
                        if ($hasConversation) {
                            foreach ($fullConversation as $message) { ?>
                                <div class="message-container <?= $message->getSenderId() === $_SESSION['userId'] ? 'sent' : 'received'; ?> flex flex-col">
                                    <div class="message-context flex items-center">
                                        <?php
                                        if ($message->getSenderId() === $interlocutor->getId()) { ?>
                                            <img src="img/users/<?= $interlocutor->getAvatar(); ?>" alt="Photo de profil de <?= $interlocutor->getUsername(); ?>" class="conversation-interlocutor-avatar">
                                        <?php } ?>
                                        <p class="conversation-message-time"><?= Utils::formatDatetime($message->getCreatedAt(), true); ?></p>
                                    </div>
                                    <div class="message-content">
                                        <p><?= $message->getContent(); ?></p>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </div>
                </div>
                <form action="index.php?action=send-message&userid=<?= $interlocutor->getId(); ?>" method="post" class="message-form flex items-center">
                    <input type="text" name="message" id="message" placeholder="Tapez votre message ici">
                    <input type="submit" value="Envoyer" class="btn btn-primary">
                </form>
            <?php } else { ?>
                <p>Aucune conversation à afficher</p>
            <?php } ?>
        </div>
    </div>
</section>