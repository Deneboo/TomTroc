<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\UserRepository;
use App\Services\ImageUploadService;

class UserController
{
    private UserRepository $userRepository;
    private ImageUploadService $imageUploadService;

    public function __construct(DBConnect $database)
    {
        $this->userRepository = new UserRepository($database->getConnection());
        $this->imageUploadService = new ImageUploadService();
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
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?action=loginPage');
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
        $_SESSION['flash_success_info'] = "Vos modifications ont bien été enregistrées.";

        header('Location: index.php?action=profile');
        exit;
    }

    public function uploadAvatar(): void
    {
        $userId = (int) $_SESSION['user_id'];

        $result = $this->imageUploadService->uploadImage(
            'avatar',
            $userId,
        );

        if ($result['success']) {
            $user = $this->userRepository->findUserById($userId);
            $user->setAvatar($result['path']);

            $this->userRepository->update($user);
        }

        $_SESSION['flash_error_upload_file'] = $result['error'];
        $_SESSION['flash_success_upload_file'] = $result['message'];

        header('Location: index.php?action=profile');
        exit;
    }

    // public function uploadAvatar(): void
    // {
    //     if (!isset($_SESSION['user_id'])) {
    //         header('Location: index.php?action=loginPage');
    //         exit;
    //     }

    //     $errorFile = null;
    //     $messageSuccess = null;

    //     $user = $this->userRepository->findUserById($_SESSION['user_id']);

    //     $targetDir = __DIR__ . "/../../public/assets/uploads/" . $user->getId() . "/avatar/";

    //     if (!is_dir($targetDir)) {
    //         mkdir($targetDir, 0777, true);
    //     }

    //     $targetFile = $targetDir . basename($_FILES["fileToUpload"]["name"]);

    //     $uploadOk = 1;
    //     $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    //     if (isset($_POST["submit"])) {
    //         $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    //         if ($check !== false) {
    //             $uploadOk = 1;
    //         } else {
    //             $errorFile   =  "Le fichier n'est pas une image valide..";
    //             $uploadOk = 0;
    //         }
    //     }

    //     if (file_exists($targetFile)) {
    //         $errorFile   = "Le fichier existe déjà.";
    //         $uploadOk = 0;
    //     }

    //     if ($_FILES["fileToUpload"]["size"] > 200000) {
    //         $errorFile   =  "Votre fichier est trop volumineux. La taille maximale autorisée est de 200 Ko.";
    //         $uploadOk = 0;
    //     }

    //     if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    //     && $imageFileType != "gif") {
    //         $errorFile   =  "Seul les fichiers JPG, JPEG, PNG & GIF sont autorisés.";
    //         $uploadOk = 0;
    //     }

    //     if ($uploadOk == 0) {
    //         $errorFile   =  "Le téléchargement de votre fichier a échoué.";
    //     } else {
    //         if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
    //             $filePath = "/assets/uploads/" . $user->getId() . "/avatar/" . basename($_FILES["fileToUpload"]["name"]);
    //             $user->setAvatar($filePath);
    //             $messageSuccess = "Votre avatar a été mis à jour avec succès.";

    //             $this->userRepository->update($user);
    //         } else {
    //             $errorFile   = "Une erreur s'est produite lors du téléchargement de votre fichier.";
    //         }
    //     }
    //     $_SESSION['flash_error_avatar'] = $errorFile;
    //     $_SESSION['flash_success_avatar'] = $messageSuccess;

    //     header('Location: index.php?action=profile');
    //     exit;
    // }

}
