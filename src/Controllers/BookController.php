<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\BookRepository;
use App\Repository\UserRepository;
use App\Controllers\ErrorController;
use App\Models\Book;
use App\Services\ImageUploadService;
use App\Validators\ImageValidator;

class BookController
{
    private BookRepository $bookRepository;
    private UserRepository $userRepository;
    private ImageUploadService $imageUploadService;
    private ImageValidator $imageValidator;

    public function __construct(DBConnect $database)
    {
        $this->bookRepository = new BookRepository($database->getConnection());
        $this->userRepository = new UserRepository($database->getConnection());
        $this->imageUploadService = new ImageUploadService($database);
        $this->imageValidator = new ImageValidator();
    }
    public function bookList(): void
    {
        $books = $this->bookRepository->findAll();
        View::render('Templates/Site/books', [
            'books' => $books,
        ]);
    }

    public function bookDetails(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $book = $this->bookRepository->findById($id);

        if ($book === null) {
            $errorMessage = "La livre demandé est introuvable.";
            (new ErrorController())->error404($errorMessage);
            return;
        }


        View::render('Templates/Site/book', [
            'book' => $book,
        ]);
    }

    public function bookSearch(): void
    {
        $title = $_GET['title'] ?? '';
        $books = $this->bookRepository->searchByTitle($title);
        View::render('Templates/Site/books', [
            'books' => $books,
        ]);
    }

    public function addEditBookForm(): void
    {
        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : null;
        $book = null;

        if ($bookId !== null) {
            $book = $this->bookRepository->findById($bookId);

            if ($book === null || $book->getUser()->getId() !== $_SESSION['user_id']) {
                $errorMessage = "Le livre demandé est introuvable ou vous n'avez pas la permission de le modifier.";
                (new ErrorController())->error404($errorMessage);
                return;
            }
        }

        View::render('Templates/Site/addEditBook', [
            'book' => $book,
        ]);
    }

    public function addEditBook(): void
    {
        $bookId = isset($_POST['id']) ? (int) $_POST['id'] : null;

        $title = trim($_POST['title'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $image = $_POST['image'] ?? null;
        $userId = $_SESSION['user_id'];
        $isAvailable = isset($_POST['isAvailable']) ? (bool) $_POST['isAvailable'] : true;

        if (empty($title) || empty($author) || empty($description)) {
            $error = "Tous les champs sont obligatoires.";
            View::render('Templates/Site/addEditBook', [
                'error' => $error,
                'book' => [
                    'id' => $bookId,
                    'title' => $title,
                    'author' => $author,
                    'description' => $description,
                ],
            ]);
            return;
        }

        if ($bookId !== null) {
            $book = $this->bookRepository->findById($bookId);

            if ($book === null || $book->getUser()->getId() !== $_SESSION['user_id']) {
                $errorMessage = "Le livre demandé est introuvable ou vous n'avez pas la permission de le modifier.";
                (new ErrorController())->error404($errorMessage);
                return;
            }

            $newBook = new Book(
                $bookId,
                $title,
                $author,
                $description,
                new \DateTime(),
                $book->getUser(),
                $isAvailable,
                $image ? $image : $book->getImage(),
            );

            $this->bookRepository->update($newBook);
            $_SESSION['flash_success_edit_book'] = "Votre livre  a bien été modifié.";
        } else {
            $user = $this->userRepository->findUserById($userId);

            $newBook = new Book(
                0,
                $title,
                $author,
                $description,
                new \DateTime(),
                $user,
                '1',
                $image ?? '',
            );
            $bookId = $this->bookRepository->insert($newBook);

            if (!empty($_FILES['fileToUpload']['tmp_name'])) {
                $path = $this->imageUploadService->uploadImage(
                    'book_cover',
                    $userId,
                    $bookId
                );

                if ($path) {
                    $book = $this->bookRepository->findById($bookId);
                    $book->setImage($path);

                    $this->bookRepository->update($book);
                }
            }
            $_SESSION['flash_success_add_book'] = "Votre livre  a bien été ajouté.";
        }

        header('Location: index.php?action=account');
        exit;
    }

    public function uploadImage(): void
    {
        $bookId = isset($_POST['id']) ? (int) $_POST['id'] : null;
        $userId = (int) $_SESSION['user_id'];
        $imageType = 'book_cover';

        $error = $this->imageValidator->validate(
            $_FILES['fileToUpload'],
            $imageType,
        );

        if ($error !== null || $bookId === null) {
            $_SESSION['flash_error_upload_book_cover'] = $error;
            header('Location: index.php?action=account');
            exit;
        }

        try {
            $path = $this->imageUploadService->uploadImage(
                $imageType,
                $userId,
                $bookId
            );
            if ($path) {
                $book = $this->bookRepository->findById($bookId);
  
                if ($book->getImage() == null) {
                    $book->setImage($path);

                    $this->bookRepository->update($book);

                }
                $_SESSION['flash_success_upload_book_cover'] = "Image modifiée avec succès.";
            }
        } catch (\RuntimeException $e) {
            $_SESSION['flash_error_upload_book_cover']
                = "Une erreur s'est produite lors du téléchargement de la couverture.";
        }

        header('Location: index.php?action=addEditBookForm&id=' . $bookId);
        exit;
    }

    public function deleteBook(): void
    {
        $bookId = isset($_GET['id']) ? (int) $_GET['id'] : null;

        if ($bookId === null) {
            $errorMessage = "Aucun livre spécifié pour la suppression.";
            (new ErrorController())->error404($errorMessage);
            return;
        }

        $book = $this->bookRepository->findById($bookId);

        if ($book === null || $book->getUser()->getId() !== $_SESSION['user_id']) {
            $errorMessage = "Le livre demandé est introuvable ou vous n'avez pas la permission de le supprimer.";
            (new ErrorController())->error404($errorMessage);
            return;
        }

        $this->bookRepository->delete($bookId);

        header('Location: index.php?action=account');
        exit;
    }
}
