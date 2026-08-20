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

<div class="page-container">
    <div class="messaging-page">
        <div class="all-messages">
            <h1>Messagerie</h1>
              <ul>
                  <?php foreach ($latestMessages as $latest): 
                      $message = $latest['message'];
                      $interlocuteur = $latest['interlocuteur'];
                  ?>
                      <li>
                          <a href="index.php?action=messaging&id=<?= $interlocuteur->getId() ?>"
                          class="avatar-and-name"
                          >
                            <img
                                src="<?= htmlspecialchars($interlocuteur->getAvatar()) ?>"
                                alt="avatar"
                            >
                            <p><?= htmlspecialchars($interlocuteur->getUsername()) ?></p>
                            <p><?= htmlspecialchars($message->getMessage()) ?></p>
                        </a>
                      </li>
                  <?php endforeach; ?>   
              </ul>
        </div> 
        <?php if ($selectedInterlocuteur !== null) : ?>
            <div class="messaging">  
                <div class="sender-name">
                    <a href="index.php?action=profile&id=<?= $selectedInterlocuteurId ?>" class="avatar-and-name">
                          <img src="<?= htmlspecialchars($selectedInterlocuteurAvatar) ?>" alt="avatar">
                          <p>
                              <?= htmlspecialchars($selectedInterlocuteurUsername) ?>
                          </p>
                      </a>
                  </div>
                <div class="current-message">
                      <?php foreach ($messages as $message): 
                      $isSender = $_SESSION['user_id'] === $message->getSender()->getId()
                      ? 'owner'
                      : 'interlocuteur';
                      ?>
                          <div class="<?= $isSender ?>">
                                <p><?= $isSender ?></p>
                                <p><?= $message->getCreatedAt()->format('d/m/Y à H:i') ?></p>
                                <p><?= $message->getMessage() ?></p>
                          </div>
                      <?php endforeach ?>
                </div>
                <div class="message-form">
                      
                </div>
            </div>
        <?php endif ?>
    </div>
</div>