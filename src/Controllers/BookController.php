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
        View::render('Templates/Site/book');
    }
}
