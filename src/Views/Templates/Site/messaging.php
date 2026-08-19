<?php
/**
 * User messaging page.
 */

/** @var App\Models\User $user */
/**@var App\Models\Message[] $messages */
var_dump($messages);
?>

<div class="page-container">
    <div class="messaging-page">
        <div class="all-messages">
            <h1>Messagerie</h1>
            <ul>
                <?php foreach ($messages as $message): 
                ?>
                  
              
                  <p><?= $message->getSenderId() ?> </p>
                    <p><?= $message->getMessage() ?> </p>
                <?php endforeach; ?>
            </ul>
        </div> 
        <div class="messaging">
          
            <div class="sender-name"></div>
            <div class="current-message">

            </div>
            <div class="message-form">

            </div>
        </div>
    </div>
</div>