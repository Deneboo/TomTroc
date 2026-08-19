<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\MessageRepository;

class MessageController 
{
    private MessageRepository $messageRepository;

    public function __construct(DBConnect $database)
    {
        $this->messageRepository = new MessageRepository($database->getConnection());
    }

    public function getAllLatestMessageForASuser(): void 
    {
        if (isset($_SESSION['user'])) {
            header('Location: index.php?action=loginPage');
            exit;
        }
        $userId = $_SESSION['user'];

        $messages = $this->messageRepository->getAllLatestMessagesByUserId($userId);
        var_dump($messages);
        exit();
        View::render('Templates/Site/messaging', [
            'messages' => $messages,
        ]);

    }
}