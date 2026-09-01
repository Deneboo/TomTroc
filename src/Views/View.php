<?php

namespace App\Views;

use App\Repository\MessageRepository;
use App\Database\DBConnect;
class View
{
    public static function render(string $view, array $data = []): void
    {
        if (isset($_SESSION['user_id'])) {
            $database = DBConnect::getInstance();
            $messageRepository = new MessageRepository($database->getConnection());
            $data['hasUnreadMessages'] = $messageRepository->hasUnreadMessages(
                (int) $_SESSION['user_id']
            );
            $data['unreadMessagesCount'] = $messageRepository->countUnreadMessages(
                (int) $_SESSION['user_id']
            );
        } else {
            $data['hasUnreadMessages'] = false;
        }

        extract($data);

        ob_start();
        require __DIR__ . '/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/Templates/Layouts/main.php';
    }
}
