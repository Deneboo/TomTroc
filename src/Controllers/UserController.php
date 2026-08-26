<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\UserRepository;
use App\Repository\MessageRepository;
use App\Services\ImageUploadService;
use App\Validators\ImageValidator;
use App\Exceptions\ImageUploadException;

class UserController
{
    private UserRepository $userRepository;
    private MessageRepository $messageRepository;
    private ImageUploadService $imageUploadService;
    private ImageValidator $imageValidator;

    public function __construct(DBConnect $database)
    {
        $this->userRepository = new UserRepository($database->getConnection());
        $this->messageRepository = new MessageRepository($database->getConnection());
        $this->imageUploadService = new ImageUploadService();
        $this->imageValidator = new ImageValidator();
    }

    public function loginPage(): void
    {
        View::render('Templates/Site/login');
    }

    public function registerPage(): void
    {
        View::render('Templates/Site/register');
    }

    public function getAccount(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=loginPage');
            exit;
        }

        $user = $this->userRepository->findUserById($_SESSION['user_id']);
        $books = $this->userRepository->findByUserId($_SESSION['user_id']);
        $bookCount = count($books);
        View::render(
            'Templates/Site/account',
            [
                'user' => $user,
                'books' => $books,
                'bookCount' => $bookCount,
            ],
        );
    }

    public function getPublicAccount(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=loginPage');
            exit;
        }

        $userToVisit = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if (!$userToVisit) {
            header('Location: index.php?action=home');
            exit;
        }

        try {
            $userProfile = $this->userRepository->findUserById($userToVisit);
            $books = $this->userRepository->findByUserId($userToVisit);
            $bookCount = count($books);

            if ($userToVisit == $_SESSION['user_id']) {
                View::render(
                    'Templates/Site/account',
                    [
                        'user' => $userProfile,
                        'books' => $books,
                        'bookCount' => $bookCount,
                    ],
                );
            }


            View::render(
                'Templates/Site/publicAccount',
                [
                    'user' => $userProfile,
                    'books' => $books,
                    'bookCount' => $bookCount,
                ],
            );
        } catch (\Exception $e) {
            error_log($e->getMessage());

            header('Location: index.php?action=error');
            exit;
        }
    }

    public function updateaccount(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $this->userRepository->findUserById($_SESSION['user_id']);

        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        $user->setEmail($email);
        $user->setUsername($username);

        if (empty($email) || empty($username) || empty($password)) {
            $user->setEmail($user->getEmail());
            $user->setUsername($user->getUsername());
        }

        $existingUser = $this->userRepository->findByEmailOrUsername($email, $username);

        if ($existingUser !== null && $existingUser->getId() !== $user->getId()) {
            if ($existingUser->getEmail() === $email) {
                $error = "Cet adresse e-mail est déjà utilisée.";
            } else {
                $error = "Ce nom d'utilisateur est déjà pris.";
            }

            View::render('Templates/Site/account', [
                'error' => $error,
                'user' => $user,
            ]);
            return;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($hashedPassword);
        }

        $this->userRepository->update($user);
        $_SESSION['flash_success_info'] = "Vos modifications ont bien été enregistrées.";

        header('Location: index.php?action=account');
        exit;
    }

    public function uploadAvatar(): void
    {
        $userId = (int) $_SESSION['user_id'];
        $imageType = 'avatar';

        try {
            $this->imageValidator->validate(
                $_FILES['fileToUpload'],
                $imageType,
            );
        } catch (ImageUploadException $e) {
            $_SESSION['flash_error_upload_avatar'] = $e->getMessage();
            header('Location: index.php?action=account');
            exit;
        }

        try {
            $path = $this->imageUploadService->uploadImage(
                $imageType,
                $userId,
            );

            if ($path) {
                $user = $this->userRepository->findUserById($userId);
                $user->setAvatar($path);

                $this->userRepository->update($user);
                $_SESSION['flash_success_upload_avatar'] = "Avatar modifié avec succès.";
            }
        } catch (ImageUploadException $e) {
            $_SESSION['flash_error_upload_avatar'] = $e->getMessage();
            header('Location: index.php?action=account');
            exit;
        }

        header('Location: index.php?action=account');
        exit;
    }

    public function getMessagingView(): void
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }
        $userId = $_SESSION['user_id'];
        $user = $this->userRepository->findUserById($userId);

        $latestMessages = $this->messageRepository->getAllLatestMessagesForOneUser($userId, $user);

        $messages = [];
        $selectedInterlocuteurId = isset($_GET['id'])
            ? (int) $_GET['id']
            : null;
        $conversationId = null;
        $selectedInterlocuteur = null;
        
        if ($selectedInterlocuteurId !== null) {
            $selectedInterlocuteur = $this->userRepository->findUserById($selectedInterlocuteurId);

            $conversation = $this->messageRepository->getOneConversation(
                $userId,
                $selectedInterlocuteurId
            );
            if ($conversation !== null) {
                $conversationId = $conversation['id'];
                $messages = $this->messageRepository->getAllMessageFromAConversation($conversationId);
            } else {
                $conversationId = null;
                $messages = [];
            }
        }

        View::render(
            'Templates/Site/messaging',
            [
                'user' => $user,
                'messages' => $messages,
                'latestMessages' => $latestMessages,
                'selectedInterlocuteur' => $selectedInterlocuteur,
            ],
        );
    }
}
