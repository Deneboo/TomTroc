<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\UserRepository;
use App\Repository\BookRepository;

class UserController
{
    private UserRepository $userRepository;
    private BookRepository $bookRepository;

    public function __construct(DBConnect $database)
    {
        $this->userRepository = new UserRepository($database->getConnection());
        $this->bookRepository = new BookRepository($database->getConnection());
    }

    public function loginPage(): void
    {
        View::render('Templates/Site/login');
    }

    public function registerPage(): void
    {
        View::render('Templates/Site/register');
    }

    public function getProfile(): void
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=login');
            exit;
        }

        $user = $this->userRepository->findUserById($_SESSION['user_id']);
        $books = $this->userRepository->findByUserId($_SESSION['user_id']);
        $bookCount = count($books);
        View::render(
            'Templates/Site/profile',
            [
                'user' => $user,
                'books' => $books,
                'bookCount' => $bookCount,
            ],
        );
    }

    public function updateProfile(): void
    {
        session_start();

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

            View::render('Templates/Site/profile', [
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
        $_SESSION['flash_success'] = "Vos modifications ont bien été enregistrées.";

        header('Location: index.php?action=profile');
        exit;
    }
}
