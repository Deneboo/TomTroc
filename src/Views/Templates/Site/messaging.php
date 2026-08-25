<?php
/**
 * User messaging page.
 */

/** @var App\Models\User $selectedInterlocuteur */
/** @var App\Models\Message[] $messages */
/** @var App\Models\Message $message */
/** @var App\Models\Message[] $latestMessages */
/** @var mixed $latest */

if ($selectedInterlocuteur !== null) {
    $selectedInterlocuteurId = $selectedInterlocuteur->getId();
    $selectedInterlocuteurAvatar = $selectedInterlocuteur->getAvatar();
    $selectedInterlocuteurUsername = $selectedInterlocuteur->getUsername();
} 

?>

<div class="page-container messaging">
    <div class="messaging-page">
        <div class="all-messages">
            <h1>Messagerie</h1>
            <ul>
                <?php foreach ($latestMessages as $latest):
                    $message = $latest['message'];
                    $interlocuteur = $latest['interlocuteur'];
                ?>
                    <li>
                        <a 
                            href="index.php?action=messaging&id=<?= $interlocuteur->getId() ?>"
                            class="last-message"
                        >
                            <img
                                src="<?= htmlspecialchars($interlocuteur->getAvatar()) ?>"
                                alt="avatar"
                                class="avatar-message"
                            >
                            <div>
                                <div class="last-message-header">
                                    <p><?= htmlspecialchars($interlocuteur->getUsername()) ?></p>
                                    <p><?= htmlspecialchars($message->getCreatedAt()->format('H:i')) ?></p>
                                </div>
                                
                                <p class="message-list-text"><?= htmlspecialchars($message->getMessage()) ?></p>
                            </div>
                        </a>
                    </li>
                <?php
                endforeach; ?>   
            </ul>
        </div> 
        <div class="messaging-conversation"> 
            <?php if ($selectedInterlocuteur !== null): ?> 
                          
                    <div class="sender-name">
                        <a href="index.php?action=profile&id=<?= $selectedInterlocuteurId ?>" class="avatar-and-name">
                            <img 
                                src="<?= htmlspecialchars($selectedInterlocuteurAvatar,) ?>" 
                                alt="avatar"
                                class="avatar-message"
                            >
                            <p>
                                <?= htmlspecialchars($selectedInterlocuteurUsername) ?>
                            </p>
                        </a>
                    </div>

                    <div class="current-message">
                        <?php foreach ($messages as $message):
                            $isSender =
                                $_SESSION['user_id'] === $message->getSender()->getId()
                                    ? 'owner'
                                    : 'interlocuteur'; ?>
                            <div class="<?= $isSender ?>">
                                <div class="messaging-conversation-header">
                                <?php if ($isSender === 'interlocuteur') : ?>
                                    <img 
                                        src="<?= htmlspecialchars($selectedInterlocuteurAvatar,) ?>" 
                                        alt="avatar"
                                        class="avatar-message"
                                    >
                                <?php endif ?>
                                    <p class="message-date"><?= $message->getCreatedAt()->format('d.m H:i') ?></p>
                                </div>
                                <p class="message-content"><?= $message->getMessage() ?></p>
                            </div>
                        <?php
                        endforeach; ?>
                    </div>
               
                <div class="message-form">
                    <form class="add-edit-book-form form-details" method="post" action="index.php?action=sendMessage&id=<?= $selectedInterlocuteurId ?>">
                        <div>
                            <input id="messageToSend" name="messageToSend" placeholder="Tapez votre message ici" class="message-input"></input>
                        </div>
                        <button type="submit" class="submit btn btn-form btn-primary message-button">Envoyer</button>
                    </form>  
                </div>            
            <?php endif; ?>
        </div>
    </div>
</div>