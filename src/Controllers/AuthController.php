<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Models\User;
use App\Repository\UserRepository;
use App\Views\View;

class AuthController
{
    private UserRepository $userRepository;

    public function __construct(DBConnect $database)
    {
        $this->userRepository = new UserRepository($database->getConnection());
    }

    public function register(): void
    {
        $email = trim($_POST['email'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($username) || empty($password)) {
            $error = "Tous les champs sont obligatoires.";
            View::render('Templates/Site/register', ['error' => $error]);
            return;
        }

        $existingUser = $this->userRepository->findByEmailOrUsername($email, $username);

        if ($existingUser !== null) {
            if ($existingUser->getEmail() === $email) {
                $error = "Cet adresse e-mail est déjà utilisée.";
            } else {
                $error = "Ce nom d'utilisateur est déjà pris.";
            }

            View::render('Templates/Site/register', [
                'error' => $error,
                'old_email' => $email,
                'old_username' => $username,
            ]);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $user = new User(
            0,
            $username,
            $email,
            $hashedPassword,
            '/assets/images/default-avatar.png',
            new \DateTime(),
        );

        $this->userRepository->insert($user);

        View::render('Templates/Site/login', ['success' => 'Votre compte a bien été créé !']);
    }

    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            View::render('Templates/Site/login');
            return;
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userRepository->findUserByEmail($email);


        if ($user && password_verify($password, $user->getPassword())) {

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user->getId();

            header('Location: index.php?action=profile');
            exit;
        }

        $error = "Email ou mot de passe incorrect.";

        View::render('Templates/Site/login', [
            'error' => $error,
            'email' => $email,
        ]);
    }

    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        session_destroy();

        header('Location: index.php');
        exit();
    }
}
