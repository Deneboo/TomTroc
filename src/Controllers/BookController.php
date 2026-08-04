<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\BookRepository;
use App\Controllers\ErrorController;

class BookController
{
    private BookRepository $bookRepository;

    public function __construct(DBConnect $database)
    {
        $this->bookRepository = new BookRepository($database->getConnection());
    }
    public function bookList(): void
    {
        if (isset($_SESSION['user'])) {
            return;
        }
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
            if ($book === null) {
                $errorMessage = "La livre demandé est introuvable.";
                (new ErrorController())->error404($errorMessage);
                return;
            }
        }


        View::render('Templates/Site/book', [
            'book' => $book,
        ]);
    }
}
