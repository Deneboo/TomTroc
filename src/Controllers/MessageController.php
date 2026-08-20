<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Repository\MessageRepository;
use App\Repository\ConversationRepository;

class MessageController
{
      private MessageRepository $messageRepository;
      private ConversationRepository $conversationRepository;

      public function __construct(DBConnect $database)
      {
          $this->messageRepository = new MessageRepository($database->getConnection());
          $this->conversationRepository = new ConversationRepository($database->getConnection());
      }

      public function sendMessage(): void 
      {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=loginPage');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $interlocuteurId = (int) $_GET['id'];
        $message = $_POST['messageToSend'];
    
        $conversation = $this->conversationRepository->getConversationByUsersIds($userId, $interlocuteurId);
        $conversationId = null;
        if (!$conversation) {
            $conversationId = $this->conversationRepository->insert($userId, $interlocuteurId);
        } else {
            $conversationId = $conversation->getId();
        }

        $this->messageRepository->insert(
            $message,
            $userId,
            $interlocuteurId,
            $conversationId
        );

        header('Location: index.php?action=messaging&id=' . $interlocuteurId);
        exit;
    }
}