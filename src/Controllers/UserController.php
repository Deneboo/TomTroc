<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\UserRepository;
use App\Services\ImageUploadService;
use App\Validators\ImageValidator;

class UserController
{
    private UserRepository $userRepository;
    private ImageUploadService $imageUploadService;
    private ImageValidator $imageValidator;

    public function __construct(DBConnect $database)
    {
        $this->userRepository = new UserRepository($database->getConnection());
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

    public function getProfile(): void
    {
        // if (!isset($_SESSION['user_id'])) {
        //     header('Location: index.php?action=loginPage');
        //     exit;
        // }

        $userToVisit = isset($_GET['id']) ? (int) $_GET['id'] : null;
        // var_dump($userToVisit);
        // exit();
        if (!$userToVisit) {
            header('Location: index.php?action=home');
            exit;
        }

        try {
            $userProfile = $this->userRepository->findUserById($userToVisit);
            $books = $this->userRepository->findByUserId($userToVisit);

            $bookCount = count($books);

            View::render(
                'Templates/Site/profile',
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

        $error = $this->imageValidator->validate(
            $_FILES['fileToUpload'],
            $imageType
        );

        if ($error !== null) {
            $_SESSION['flash_error_upload_avatar'] = $error;

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
        // Deal with exeption from the service
        } catch (\RuntimeException $e) {
            // var_dump($e->getMessage());
            $_SESSION['flash_error_upload_avatar']
                = "Une erreur s'est produite lors du téléchargement de votre avatar.";
        }

        header('Location: index.php?action=account');
        exit;
    }
}
