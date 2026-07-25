<?php

namespace App\Controllers;

use App\Database\DBConnect;
use App\Views\View;
use App\Repository\BookRepository;

class BookController
{
    private BookRepository $bookRepository;

    public function __construct(DBConnect $database)
    {
        $this->bookRepository = new BookRepository($database->getConnection());
    }
    public function bookList(): void
    {
        $books = $this->bookRepository->findAll();
        View::render('Templates/Site/books', [
            'books' => $books
        ]);
    }

    public function bookDetails(): void
    {
        $id = (int) ($_GET['id'] ?? 0);

        $book = $this->bookRepository->findById($id);

        if ($book === null) {
            throw new \Exception("Le livre demandé n'existe pas.");
        }

        View::render('Templates/Site/book', [
            'book' => $book,
        ]);
    }
}
