<?php

// ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/../vendor/autoload.php';

use App\Database\DatabaseInitialize;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Controllers\BookController;
use App\Controllers\ErrorController;
use App\Database\DBConnect;

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 60 * 60 * 24 * 30, // 30 days
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// Initiate database if not exists
$dbInitialize = new DatabaseInitialize();

$dbInitialize->initialize();
$database = DBConnect::getInstance();

try {

    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    if ($path !== '/index.php') {
        header('Location:  /index.php?action=error404');
        exit;
    }

    $homeController = new HomeController($database);
    $bookController = new BookController($database);
    $authController = new AuthController($database);
    $userController = new UserController($database);
    $errorControler = new ErrorController();

    switch ($_GET['action'] ?? 'home') {
        case 'home':
            $homeController->index();
            break;
        case 'books':
            $bookController->bookList();
            break;
        case 'search':
            $bookController->bookSearch();
            break;
        case 'book':
            $bookController->bookDetails();
            break;
        case 'addEditBook':
            $bookController->addEditBookForm();
            break;
        case 'addEditBookPost':
            $bookController->addEditBook();
            break;
        case 'deleteBook':
            $bookController->deleteBook();
            break;
        case 'register':
            $authController->register();
            break;
        case 'login':
            $authController->login();
            break;
        case 'logout':
            $authController->logout();
            break;
        case 'loginPage':
            $userController->loginPage();
            break;
        case 'registerPage':
            $userController->registerPage();
            break;
        case 'profile':
            $userController->getProfile();
            break;
        case 'updateProfile':
            $userController->updateProfile();
            break;
        case 'uploadAvatar':
            $userController->uploadAvatar();
            break;
        default:
            $errorControler->error404("La page demandée n'existe pas.");
            break;
    }
} catch (\Throwable $e) {
    // var_dump($e->getMessage());
    $errorControler->error500();
}
