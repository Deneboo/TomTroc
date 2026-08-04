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

    switch ($_GET['action'] ?? 'home') {
        case 'home':
            $homeController = new HomeController($database);
            $homeController->index();
            break;
        case 'books':
            $bookController = new BookController($database);
            $bookController->bookList();
            break;
        case 'book':
            $bookController = new BookController($database);
            $bookController->bookDetails();
            break;
        case 'login':
            $userController = new UserController($database);
            $userController->loginPage();
            break;
        case 'loginPost':
            $authController = new AuthController($database);
            $authController->login();
            break;
        case 'register':
            $userController = new UserController($database);
            $userController->registerPage();
            break;
        case 'registerPost':
            echo "Route registerPost OK";
            $authController = new AuthController($database);
            $authController->register();
            break;
        case 'logout':
            $authController = new AuthController($database);
            $authController->logout();
            break;
        case 'profile':
            $userController = new UserController($database);
            $userController->getProfile();
            break;
        case 'updateProfile':
            $userController = new UserController($database);
            $userController->updateProfile();
            break;
        case 'uploadAvatar':
            $userController = new UserController($database);
            $userController->uploadAvatar();
            break;
        default:
            $errorControler = new ErrorController();
            $errorControler->error404("La page demandée n'existe pas.");
            break;
    }
} catch (\Throwable $e) {
    var_dump($e->getMessage());
    // $errorControler = new ErrorController();
    // $errorControler->error500();
}
